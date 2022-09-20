<div class="container-fluid">
    <h5>Определите ценовые диапазоны:</h5>
    <div class="form-group-sm well well-sm">
        <h5>Дешёвые товары:</h5>
        <div class="col-sm-6">
            <label>От:</label>
            <input class="form-control" id="fp1" type="text" disabled value="0">
        </div>
        <div class="col-sm-6">
            <label>До:</label>
            <input class="form-control" id="tp1" type="text" value="1000">
        </div>
    </div>
    <div class="form-group-sm">
        <h5>Товары средней цены:</h5>
        <div class="col-sm-6">
            <label>От:</label>
            <input class="form-control" id="fp2" type="text" disabled value="1001">
        </div>
        <div class="col-sm-6">
            <label>До:</label>
            <input class="form-control" id="tp2" type="text" value="10000">
        </div>
    </div>
    <div class="form-group-sm">
        <h5>Дорогие товары:</h5>
        <div class="col-sm-6">
            <label>От:</label>
            <input class="form-control" id="fp3" type="text" disabled value="10001">
        </div>
        <div class="col-sm-6">
            <label>До:</label>
            <input class="form-control" id="tp3" type="text" >
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on('input', '#tp1', function(){
        $('#fp2').val(parseInt($(this).val())+1);
    });
    $(document).on('input', '#tp2', function(){
        $('#fp3').val(parseInt($(this).val())+1);
    });
</script>