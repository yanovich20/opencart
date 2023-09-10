$(document).ready(function () {
    let isajax =1;
    let markByLink = "";
    let mark= $("select#make").val();
    let model = $("select#model").val();
    let priceFrom = $("input#priceFrom").val();
    let priceTo = $("input#priceTo").val();
    let fuel =$("select#fuel").val();
    let gearBox = $("select#transmission").val();
    let yearFrom =$("select#year-from").val();
    let yearTo =$("select#year-to").val();
    

    $("button.form__button").on("click", function () {
        getCarsCard();
    });
    $("div.catalog__sort a").on("click",function(){
        getCarsCard();
    });
    $("div.catalog").on("click","div.pagelist a",function(){
        page = $(this)[0].innerText;
        getCarsCard();
    });
    $("ul.sidebar__list a").on("click",function(){
        markByLink = $(this).attr("data-id");
        getparams();
        console.log(mark);
        let data ={
            isajax:1,
            mark:mark,
            sortBy:sortBy,
            sortOrder:sortOrder,
            page:page
        }
        $.ajax({
            url: '/index.php?route=Cars/Card',
            method: 'post',
            dataType: 'text',
            data: data,
            success: function (data) {
                $("div.list__cars")[0].innerHTML = data;
            }
        });
    });
    function getCarsCard(){
            getparams();
            let data = {
                isajax:isajax,
                mark:mark,
                model:model,
                priceFrom:priceFrom,
                priceTo:priceTo,
                fuel:fuel,
                gearbox:gearBox,
                yearFrom:yearFrom,
                yearTo:yearTo,
                page:page,
                sortBy:sortBy,
                sortOrder:sortOrder
            }
            $.ajax({
                url: '/index.php?route=Cars/Card',
                method: 'post',
                dataType: 'text',
                data: data,
                success: function (data) {
                    $("div.list__cars")[0].innerHTML = data;
                }
            });
    }
    function getparams(){
        mark=$("select#make").val();
        if(mark==0)
            mark = markByLink;
        model = $("select#model").val();
        priceFrom = $("input#priceFrom").val();
        priceTo = $("input#priceTo").val();
        fuel =$("select#fuel").val();
        gearBox = $("select#transmission").val();
        yearFrom =$("select#year-from").val();
        yearTo =$("select#year-to").val();
        getSortOrder();
       // getPaginationParams();
    }
    let sortBy = "";
    let sortOrder = "desc";
    function getSortOrder(){
        if($("div.catalog__sort a.active").length!=0)
        {
            if($("div.catalog__sort a.active")[0].innerText.trim() =="Дата выпуска")
                sortBy = "year";
            else
                sortBy = "price";
            if($("div.catalog__sort a.active i").hasClass("catalog__icon_type_down"))
                sortOrder = "desc";
            else
                sortOrder = "asc";
        }
        else
            sortBy ="";
    }
    let page = 1;
    function getPaginationParams(){
        if($("div#pagelist a.pagelist__current").length>0)
        {
            page = $("div#pagelist a.pagelist__current")[0].innerText;
        }
    }
});
