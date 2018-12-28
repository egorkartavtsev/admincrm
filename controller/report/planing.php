<?php

class ControllerReportPlaning extends Controller{
    
    private $monthes = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];


    public function index() {
        $this->load->model('tool/layout');
        $this->load->model('tool/reports');
        $this->load->model('report/planing');
        $data = $this->model_tool_layout->getLayout($this->request->get['route']);
        $plan = $this->model_report_planing->getAdresses();
        foreach ($plan as $key => $value) {
            $curFact = $this->model_report_planing->getCurrentFact($key);
            $current = $this->model_report_planing->getCurrentPlan($key);
            if ($current === "" ||  $current === '0'){
                $currentFloor = floor($curFact*100/1);
            }
            else {
                $currentFloor = floor($curFact*100/$current);
            }
            $plan[$key] = [
                'id'            => $value,
                'current'       => $current,
                'curFact'       => $curFact,
                'totalPercent'  => $currentFloor,
                'history'       => $this->getTotalHistory($key),
                'planPerDay'    => $current?$this->planPerDay($key, $current):[],
                'currHist'      => $this->model_report_planing->getPlanChangeHistory($key)
            ];
        }
        //exit(var_dump($plan));
        $data['plans'] = $plan;
        $this->response->setOutput($this->load->view('report/planing', $data));
    }
    
    public function saveCurr() {
        $plan = $this->request->post['curr'];
        $addr = $this->request->post['addr'];
        $this->load->model('report/planing');
        $this->model_report_planing->savePlan($addr, $plan);
        $result = [];
        $result['current'] = $plan;
        $result['curFact'] = $this->model_report_planing->getCurrentFact($addr);
        $result['totalPercent'] = floor($result['curFact']*100/$plan);
        $result['history'] = $this->model_report_planing->getPlanChangeHistory($addr);
        $result['planPerDay'] = $this->planPerDay($addr, $plan);
        echo json_encode($result);
    }
    
    public function planPerDay($addr, $plan) {
        $perDay = floor($plan/date('t'));
        $res = [];
        $i = 1;
        for(; $i<date('t'); $i++){
            $day = (strlen($i)===1)?'0'.$i:$i;
            $fact = $this->model_report_planing->getCurrentFact($addr, $day);
            $perc = floor($fact*100/($perDay*$i));
            if($perc>=100){
                $class = 'success';
            } else {
                $class = 'danger progress-bar-striped active';
            }
            $div = '<div class="progress">'
                      .'<div class="progress-bar progress-bar-'.$class.'" role="progressbar" aria-valuenow="'.$perc.'" aria-valuemin="0" aria-valuemax="100" style="width: '.(($perc>100)?"100":$perc).'%">'
                        .$perc.'%'
                      .'</div>'
                  .'</div>';
            $res[$i] = [
                'date'      => $day.".".date("m.Y"),
                'plan'      => $perDay*$i,
                'fact'      => $fact,
                //'percent'   => $perc
                'percent'   => $div
            ];
        }
        $fact = $this->model_report_planing->getCurrentFact($addr);
        $perc = floor($fact*100/($plan));
        if($perc>=100){
            $class = 'success';
        } else {
            $class = 'danger progress-bar-striped active';
        }
        $div = '<div class="progress">'
                  .'<div class="progress-bar progress-bar-'.$class.'" role="progressbar" aria-valuenow="'.$perc.'" aria-valuemin="0" aria-valuemax="100" style="width: '.(($perc>100)?"100":$perc).'%">'
                    .$perc.'%'
                  .'</div>'
              .'</div>';
        $res[$i] = [
                'date'      => $i.".".date("m.Y"),
                'plan'      => $plan,
                'fact'      => $fact,
                //'percent'   => $perc
                'percent'   => $div
            ];
        return $res;
    }
    
    public function getTotalHistory($addr) {
        $allPlans = $this->model_report_planing->getTotalPlans($addr);
        $res = [];
        foreach ($allPlans as $plan) {
            $index = date('m', strtotime($plan['date']));
            $fact = $this->model_report_planing->getMonthFact(date('Y-m', strtotime($plan['date'])), $addr);
            $res[$index] = [
                'date'      => $this->monthes[(int)$index-1].' '.date('Y', strtotime($plan['date'])),
                'plan'      => $plan['plan'],
                'fact'      => $fact,
                'percent'   => floor($fact*100/($plan['plan']))
            ];
        }
        return $res;
    }
}
