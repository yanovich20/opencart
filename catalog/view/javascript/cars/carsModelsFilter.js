$(document).ready(function () {
    $("select#make").on("change", function () {
        var producerId = $("select#make").val();
        $.ajax({
            url: '/index.php?route=Cars/ModelsFilter',
            method: 'post',
            dataType: 'json',
            data: { producerId: producerId },
            success: function (data) {
                console.log(data);
                var modelsSelect = $("select#model");
                modelsSelect.empty();
                var chooseOption = '<option value="0">Выберите модель</option>';
                modelsSelect.append(chooseOption);
                for (let i = 0; i < data.length; i++) {
                    newOption = "<option value='" + data[i].model + "'>" + data[i].model + "</option>";
                    modelsSelect.append(newOption);
                }
            }
        });
    });
});