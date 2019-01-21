function validateDonorForm (){
    
    if(($("#number").val() === '') || ($("#brand").val()==='Выберите марку') || ($("#year").val()==='') || ($("#vin").val()==='')){
        alert("Заполните все обязательные поля");
    } else {
        $("#donorform").submit();
    }
    
    return false;
}

function filterDonorList(){
    ajax({
<<<<<<< Upstream, based on origin/master
            url:"index.php?route=donor/list/filter",
=======
<<<<<<< HEAD
            url:"index.php?route=donor/list/filter&token=" + getURLVar('token'),
>>>>>>> 0ccdbb6 Фиксация 21,01,2019
            statbox:"status",
            method:"POST",
            data:
            {
                param: $("#searchd").val()
            },
<<<<<<< Upstream, based on origin/master
            success:function(resp){
                $("#listDonors").html(resp);
=======
            success:function(data){
                $("#listDonors").html(data);
=======
            url:"index.php?route=donor/list/filter",
            statbox:"status",
            method:"POST",
            data:
            {
                param: $("#searchd").val()
            },
            success:function(resp){
                $("#listDonors").html(resp);
>>>>>>> origin/master
>>>>>>> 0ccdbb6 Фиксация 21,01,2019
            }
        })
}
