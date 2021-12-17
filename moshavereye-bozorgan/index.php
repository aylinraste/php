<?php
$question = "";
$msg = " ! سوال خود را بپرس ";
$abc = fopen ("messages.txt", "r");
$name1 = file_get_contents('people.json');
$name2 = json_decode($name1);
$array2 = array();
$j=1;
foreach ($name2 as $key => $value)
{
    $array2[$j]=$key;
    $j++;
}
$i=0;
$array1 =array ();
while (!feof ($abc))
{
    $array1[$i]=fgets ($abc);
    $i++;
}

if ($_SERVER["REQUEST_METHOD"] =="POST")
{
    $en_name= $_POST['person'];
    $question = $_POST["question"];
    $name1 = json_decode(file_get_contents('people.json'));
    foreach ($name1 as $key =>$value)
    {
        if ($key ==$en_name)
        {
            $fa_name=$value;
        }
    }
    if ($question=="")
    {
        $msg = " ! سوال خود را بپرس ";
    }
    else
    {
        $code =hexdec (hash("crc32" , $question ." ".$en_name));
        $tedad =16;
        $ab123 =($code % $tedad);
        $msg= $array1[$ab123];
    
        $start="/^آیا/ui";
        $end1="/\?$/i";
        $end2="/\؟$/i";
        if (!(preg_match($end1, $question) || preg_match($end2, $question) ))
        {
            $msg ="سوال درستی پرسیده نشده";
        }    
        if (!preg_match($start, $question))
        {
            $msg ="سوال درستی پرسیده نشده";
        } 
    }  

}
else 
{
    $random = array_rand($array2);
    $en_name=$array2[$random];
    foreach ($name2 as $key =>$value)
    {
        if ($key==$en_name)
        {
            $fa_name=$value;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="styles/default.css">
    <title>مشاوره بزرگان</title>
</head>
<body>
<p id="copyright">تهیه شده برای درس کارگاه کامپیوتر،دانشکده کامییوتر، دانشگاه صنعتی شریف</p>
<div id="wrapper">
    <div id="title">
        <span id="label"><?php 
        if ($question !="")
        {
            echo "پرسش:";
        }
        ?></span>
        <span id="question"><?php echo $question ?></span>
    </div>
    <div id="container">
        <div id="message">
            <p><?php echo $msg ?></p>
        </div>
        <div id="person">
            <div id="person">
                <img src="images/people/<?php echo "$en_name.jpg" ?>"/>
                <p id="person-name"><?php echo $fa_name ?></p>
            </div>
        </div>
    </div>
    <div id="new-q">
        <form method="post">
            سوال
            <input type="text" name="question" value="<?php echo $question ?>" maxlength="150" placeholder="..."/>
            را از
            <select name="person" action= "<?php echo $_SERVER['PHP_SELF'];?>">
                <?php
                $name1 = file_get_contents('people.json');
                $name2 = json_decode($name1);
                foreach($name2 as $key => $value)
                {
                    if ($en_name==$key)
                    {
                        echo"<option value=$key selected> $value</option>";
                    }
                    else
                    {
                        echo"<option value=$key> $value</option>";
                    }
                }
                ?>
            </select>
            <input type="submit" value="بپرس"/>
        </form>
    </div>
</div>
</body>
</html>