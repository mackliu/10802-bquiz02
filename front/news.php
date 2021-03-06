<?php
//建立分頁需要的相關變數及語法
$total=nums("news",["sh"=>1]);
$div=5;
$pages=ceil($total/$div);
$now=(!empty($_GET['p']))?$_GET['p']:1;
$start=($now-1)*$div;
$rows=all("news",["sh"=>1]," limit $start,$div");

?>
<div>目前位置：首頁 > 最新文章區</div>
<table>
    <tr>
        <td width="25%">標題</td>
        <td width="50%">內容</td>
        <td></td>
    </tr>
  <?php

    //用迴圈印出每一篇文章內容
    foreach($rows as $r){
  ?>
    <tr>
        <td class="clo title"  style="color:blue;cursor:pointer"><?=$r['title'];?></td>
        <td>
            <div class="line"><?=mb_substr($r['text'],0,20,"utf8");?>...</div>
            <div class="content" style="display:none"><?=nl2br($r['text']);?></div>
        </td>
        <td>
        <?php

          //依據session來決定要顯示讚或是收回讚
          if(!empty($_SESSION['user'])){
          
            //檢查log資料表中是否有會員對此篇文章的按讚紀錄
            $chk=nums("log",["news"=>$r['id'],"user"=>$_SESSION['user']]);
            
            if($chk>0){  //有按讚紀錄時顯示收回讚的文字及相關的屬性內容
          ?>
            <a id="good<?=$r['id'];?>" onclick="good('<?=$r['id'];?>','2','<?=$_SESSION['user'];?>')">收回讚</a>
          <?php
            }else{  //沒有按讚紀錄時顯示讚的文字及相關的屬性內容
          ?>
            <a id="good<?=$r['id'];?>" onclick="good('<?=$r['id'];?>','1','<?=$_SESSION['user'];?>')">讚</a>
          <?php
            }
          }
        ?>        
        </td>
    </tr>
  <?php
    }
  ?>
</table>
<div>
<?php
//建立分頁的相關連結
if(($now-1)>0){
    echo "<a href='index.php?do=news&p=".($now-1)."'> < </a>";
}

for($i=1;$i<=$pages;$i++){
    $fontSize=($i==$now)?"24px":"16px";
    echo "<a href='index.php?do=news&p=$i' style='font-size:$fontSize'> $i </a>";
}

if(($now+1)<=$pages){
    echo "<a href='index.php?do=news&p=".($now+1)."'> > </a>";
}

?>
</div>


<script>

//建立標題的點擊事件
$(".title").on("click",function(){

    //讓內容中的兩個區塊做顯示的切換
    $(this).next("td").children(".line,.content").toggle();
})

</script>