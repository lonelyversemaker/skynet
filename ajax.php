<?php
    $url = 'http://sknt.ru/job/frontend/data.json';
    $content = file_get_contents($url);
    $json = json_decode($content, true);
    

    function postfix($num)
    {
        $monthesPostfixes = array('месяц', 'месяца', 'месяцев');
        $postfix;
        $num = $num % 100;
 
        if ($num > 19)
        {
            $num = $num % 10;
        }
 
        switch ($num)
        {
            case 1:
                return $num. ' ' .$monthesPostfixes[0];
 
            case 2: case 3: case 4:
                 return $num. ' ' .$monthesPostfixes[1];
 
            default:
                 return $num. ' ' .$monthesPostfixes[2];
        }
        
    }

    foreach($json['tarifs'] as $allCategory) { 
        if ($_POST['level1']!='disable') {
?>
      <div class="item">
            <div class="itemHeader"><a class="сategory" href="#level1=disable&level2=<? echo $allCategory['title']; ?>"><h2>Тариф "<? echo $allCategory['title']; ?>"</h2></a></div>
            <div class="itemBody">
               <?
                if ($allCategory['title']=='Земля') $color = 'textBgBrown';
                if ($allCategory['title']=='Вода' || $allCategory['title']=='Вода HD') $color = 'textBgBlue';
                if ($allCategory['title']=='Огонь' || $allCategory['title']=='Огонь HD') $color = 'textBgRed';
                ?>
                <span class="textBg <? echo $color?>"><? echo $allCategory['speed']; ?> Мбит/с</span>
                <?
                    foreach($allCategory['tarifs'] as $key => $categoryOptions) {
                       $priceArray[$key] = $categoryOptions['price']/$categoryOptions['pay_period'];
                    }
                    $maxPrice = max($priceArray);
                    $minPrice = min($priceArray);
                ?>
                <p class="payment"><? echo $minPrice. ' - ' .$maxPrice. ' &#8381/мес'; ?></p>
                <div class="nextArrow">
                    <a class="сategory" href="#level1=disable&level2=<? echo $allCategory['title']; ?>"><svg enable-background="new 0 0 24 24" version="1.0" viewBox="0 0 24 24" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><polyline fill="none" points="8.5,3 17.5,12 8.5,21 " stroke="#c7c7cc" stroke-miterlimit="10" stroke-width="2"/></svg></a>
                </div>
                <div class="options">
                <? if ($allCategory['free_options'] !='') {
                    foreach($allCategory['free_options'] as $options) { ?>
                    <p><?echo $options;?></p>
                     <? }
                } ?>
                </div>
            </div>
            <div class="itemFooter">
                <a class="link" href="<? echo $allCategory['link']; ?>">узнать подробнее на сайте www.sknt.ru</a>
            </div>
        </div>
<?

 } else if($_POST['level2']!='disable') {
            
                if ($_POST['level2']==$allCategory['title']) { ?>
                   <div class="header">
                   <h1>Тариф "<? echo $allCategory['title'] ?>"</h1>
                   <div class="prevArrow">
                        <a class="сategory" href="#level1=enable&level2=disable"><svg enable-background="new 0 0 24 24" version="1.0" viewBox="0 0 24 24" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><polyline fill="none" points="8.5,3 17.5,12 8.5,21 " stroke="#82c12b" stroke-miterlimit="10" stroke-width="2"/></svg></a>
                    </div>
               </div>
               <?foreach($allCategory['tarifs'] as $key => $categoryOptions) {?>
               <div class="item itemTarif">
                    <div class="itemHeader"><a class="сategory" href="#level1=disable&level2=disable&level3=<? echo $categoryOptions['ID'] ?>"><h2><? echo postfix($categoryOptions['pay_period']) ?></h2></a></div>
                    <div class="itemBody">
                        <p class="payment"><? echo $categoryOptions['price']/$categoryOptions['pay_period']. ' &#8381/мес'; ?></p>
                        <div class="nextArrow">
                            <a class="сategory"  href="#level1=disable&level2=disable&level3=<? echo  $categoryOptions['ID'] ?>"><svg enable-background="new 0 0 24 24" version="1.0" viewBox="0 0 24 24" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><polyline fill="none" points="8.5,3 17.5,12 8.5,21 " stroke="#c7c7cc" stroke-miterlimit="10" stroke-width="2"/></svg></a>
                        </div>
                        <?
                         if ($key == 0) {
                            $maxPrice = $categoryOptions['price'];
                        }
                        $discount = ($maxPrice*$categoryOptions['pay_period'] - $categoryOptions['price']); ?>
                        <div class="options">
                            <p>разовый платеж - <? echo $categoryOptions['price']. ' &#8381'; ?></p>
                            <?if ($discount!=0) {?>
                            <p>скидка - <? echo $discount. ' &#8381'; ?></p>
                            <?}?>
                        </div>
                    </div>
                </div>
                  <? } 

           }
            } else {
            foreach($allCategory['tarifs'] as $categoryOptions) {
                if ($categoryOptions['ID'] == $_POST['level3']) { ?>
                   <div class="header">
                       <h1>Выбор тарифа</h1>
                       <div class="prevArrow">
                            <a class="сategory" href="#level1=disable&level2=<? echo $allCategory['title'] ?>"><svg enable-background="new 0 0 24 24" version="1.0" viewBox="0 0 24 24" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><polyline fill="none" points="8.5,3 17.5,12 8.5,21 " stroke="#82c12b" stroke-miterlimit="10" stroke-width="2"/></svg></a>
                        </div>
                   </div>
                   <div class="item itemTarifOpt">
                        <div class="itemHeader"><h2>Тариф "<? echo $allCategory['title'] ?>"</h2></div>
                        <div class="itemBody">
                            <div class="payment">
                            <p>Период оплаты - <? echo postfix($categoryOptions['pay_period']) ?></p>
                            <p><? echo $categoryOptions['price']/$categoryOptions['pay_period']. '&#8381/мес' ?></p>
                            </div>
                            <div class="options">
                                <p>разовый платеж - <? echo $categoryOptions['price']. ' &#8381'; ?></p>
                                <p>со счета спишется - <? echo $categoryOptions['price']. ' &#8381'; ?></p>
                            </div>
                            <div class="options secondOptions">
                                <p>вступит в силу - сегодня</p>
                                <p>активно до - <? echo date("d.m.y", $categoryOptions['new_payday']);  ?></p>
                            </div>
                            <div class="itemFooter">
                                <button class="btn">Выбрать</button>
                            </div>
                        </div>
                    </div>
            <?  }
            }
        }
    }  
    
?>