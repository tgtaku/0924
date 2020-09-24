<?php
session_start();
$project_id = $_SESSION['count'];
//mysqlとの接続
$link = mysqli_connect('localhost', 'root', '');
if (!$link) {
    die('Failed connecting'.mysqli_error());
}
//print('<p>Successed connecting</p>');

//DBの選択
$db_selected = mysqli_select_db($link , 'test_db');
if (!$db_selected){
    die('Failed Selecting table'.mysql_error());
}
//文字列をutf8に設定
mysqli_set_charset($link , 'utf8');

//pdfテーブルの取得
$result_file  = mysqli_query($link ,"SELECT pdf_name FROM pdf_information_1 where project_id = '$project_id';");
if (!$result_file) {
    die('Failed query'.mysql_error());
}
//データ格納用配列の取得
$row_array_file = array();
$i = 0;
while ($row = mysqli_fetch_assoc ($result_file)) {
    $row_array_file[$i] = $row['pdf_name'];
    //print_r($row_array_file[$i]);
    $i++;
}
$array_length = count($row_array_file);
$json_array = json_encode($row_array_file);
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>報告箇所登録画面</title>
    </head>
    <body>
    <h2>報告箇所を登録してください。</h2>
    <ul id="pdfName">
    </ul>
    <h2 id ="selectedPDF">図面名</h2>
    <div id ="div">
    <img src="test.jpg" alt = "図面を選択してください" title = "test" id ="im" >
    </div>
    <script>
        var img = document.getElementById('im');
        img.addEventListener('click', function(event){
            //画像表示位置の取得
            var elem = document.getElementById('im');
            var div = document.getElementById('div');
            var rect = elem.getBoundingClientRect();
            var elemtop = rect.top + window.pageYOffset;
            var elemleft = rect.left + window.pageXOffset;
            var elembotom = rect.bottom + window.pageYOffset;
            var elemright = rect.right + window.pageXOffset;

            //画像サイズ
            var w = elem.width;
            var w1 = parseInt(w);
            var h = elem.height;
            var h1 = parseInt(h);
            
            //画像上のクリック地点
            var x = event.pageX;
            var x1 = parseInt(x);
            var y = event.pageY;
            var y1 = parseInt(y);

            //座標上の比率を計算
            var pointX = x1/w1;
            var pointY = h1/y1;

            //var y = touch.pageY;
            alert(pointX);
            console.log(x1);
            console.log(w1);
            console.log(pointX);

            //動的にdivを作成する
            var cBall = document.createElement('d'); 
		    cBall.style.position = "absolute";
            var RandLeft = 0;
		    var RandTop = 0;
            cBall.style.left = RandLeft;
		    cBall.style.top = RandTop;
            var mark = document.createElement('img');
            mark.src = "http://10.20.170.52/web/local_pic.png";
            //Divにイメージを組み込む
		    cBall.appendChild(mark);
		    //ゲーム画面にボールレイヤ（Div)を組み込む
		    div.appendChild(cBall);
        }, false);
        </script>
    <form id="place_form">
    <table id = "place_info">
                <tr>
                    <th style="WIDTH: 15px" id="no">No</th>
                    <th style="WIDTH: 300px" id="place">施工箇所</th>
                    <th style="WIDTH: 60px" id="page">ページ</th>
                </tr>
            </table>
            <input type = "submit" id = "place_button" name="gotPlace" value = "登録">
</form>
    <script type="text/javascript">
        //var names =[];
        var names = <?php echo $json_array; ?>;
        var length = <?php echo $array_length; ?>;
        var li = [];
        //var parent = document.getElementById('pdfName');
        for (var i = 0; i < length; i++){
            li[i] = document.createElement('button');
            li[i].value = names[i];
            li[i].textContent = names[i];
            li[i].onclick = function(){getPic(this)};
            //parent.appendChild(li[i]);
            document.getElementById('pdfName').appendChild(li[i]);
        }
        //document.getElementById("pdfName").children.onclick = function(){};
    </script>
    
    <script>
        function getPic(obj){
            //var ul = document.getElementById('pdfName');
            //var ul = document.button[0];
            //var lis = ul.childNodes;
            //var li = lis[0].name;
            //var li = ul.value;
            //alert(li);
            //var li = ul.getElementsByTagName("button");
            //li[0].style.backgroudColor = "lightblue";
            //bj.style.backgroundColor = "lightblue";
            var target_name = obj.value;
            //alert(target_id);
            document.getElementById('selectedPDF').innerHTML = target_name;

            //PDFから画像を取得する処理
        }

        //var touchStartX;

        //$(".view").on("touchstart", function (e) {
        //touchStartX = e.originalEvent.changedTouches[0].pageX;
        //});

        //function imgClick(img){
            //var touchObject = img.changedTouches[0];
            //var touchX = touchObject.pageX;
            //var touchX = img.pageX;
            //var touchY = img.pageY;
            //var o = img.offsetX;
            
            //var w = img.width;
            //var h = img.height;
            
            //var touchY = touchObject.pageY;

            //要素の位置の取得
            //var clientRect = img.getBoundingClientRect();
            //var positionX = clientRect.left + window.pageXOffset;
            //var positionY = clientRect.top + window.pageYOffset;

            //要素内におけるタッチ位置の計算
            //var x = touchX - positionX;
            //var y = touchY - positionY;
            //var x = img.originalEvent.changedTouches[0].screenX;
  //var y = img['pageY'] || img.clientY;
            

            //alert(touchStartX);


            //var n = img.alt;
            //alert(n);
        //}
    </script>
    </body>

</html>