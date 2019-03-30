<?php

class ControllerToolWordTool extends Controller {
    public function index() {
        $PHPWord = new \PhpOffice\PhpWord\PhpWord();
        $document = $PHPWord->loadTemplate(DIR_DOCS.'Template.docx');
        
        $document->setValue('d_num', '9999999999'); //номер договора
        $document->setValue('d_date', '04.10.2014'); //дата договора
        $document->setValue('last_name', 'Никоненко'); //фамилия
        $document->setValue('name', 'Сергей');// имя
        $document->setValue('surname', 'Васильевич');// отчество
        $document->saveAs(DIR_DOCS.'Template_full.docx'); //имя заполненного шаблона
        
        echo HTTP_DOCS.'Template_full.docx'; //имя заполненного шаблона
    }
}