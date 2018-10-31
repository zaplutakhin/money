<?php

if (!file_exists('money.csv') or (file_exists('money.csv') and is_writable('money.csv')))
{
	if (empty($argv[1])) {exit('Ошибка! Аргументы не заданы. Укажите флаг --today или запустите скрипт с аргументами {цена} и {описание покупки}');
    }
	else
	{
	    if ($argv[1]=="--today") 
		{
			if (file_exists('money.csv')){
			$handle=fopen('money.csv', 'r');
			$i=0;		
			while (($raw = fgetcsv($handle)) !== FALSE)
			{
				if ($raw[0]===date('Y.m.d')) $i=$i+$raw[1];
			}
			echo date('d.m.Y'); echo " расход за день: $i рублей"; exit;
		} else exit('Файл со списком расходов отсутствует');
        }
	    else
	    {
		   $file=fopen('money.csv', 'a');
           $date = date ("Y.m.d");
        
		   $price=$argv[1];  
		   if(is_numeric($price))
		    {
	    	    $price=number_format($price, 2, '.', '');
			    $purchases=array_slice($argv, 2);
                $goods=implode($purchases,' ');
                $records=[$date,$price, $goods];
				if ($records[2]=="") 
				{
					exit('Ошибка! Введите описание покупки');
				} else {
					     $current = fputcsv($file, $records); echo "Добавлена строка: $date, $price, $goods";
					   }
		  
		    }
		   else exit ('Ошибка! Цена не задана или задана неверно');
	    }
	}
}
else echo 'Файл не существует или недоступен для записи';
?>