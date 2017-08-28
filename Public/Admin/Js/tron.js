/**
 * Created by pepe on 2017/8/8 0008.
 * 隔行显示表格的颜色
 */
$('.tron').mouseover(function () {

    $(this).find('td').css('backgroundColor','#BBDDE5');
});


$('.tron').mouseout(function () {

    $(this).find('td').css('backgroundColor','white');
});

