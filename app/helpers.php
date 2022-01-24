<?php


function flash($title = null, $message = null)
{
	
	$flash = app('App\Http\Flash');
	
	if( func_num_args() == 0)
	{
		return $flash;
	}
	return $flash->info($title, $message);
}

function nb($number, $decimal=2)
{
	if( $number >=0 )
		return '<span style="">'.number_format($number, $decimal).'</span>';
	else
		return '<span style="color:red;">'.number_format($number, $decimal).'</span>';
}

function thaidate( $eng_time )
{
    if( $eng_time instanceof Carbon\Carbon )
    {
        // dd($eng_time);
        $timestamp = $eng_time->timestamp;
    }
    else
    {
	   $timestamp = strtotime($eng_time);
    }
		
	 $thai_w=array("อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์");
	 $thai_n=array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
	 $w=$thai_w[date("w", $timestamp)];
	 $d=date("j", $timestamp);
	 $n=$thai_n[date("n", $timestamp) -1];
	 $y=date("Y", $timestamp) +543;
	 $t=date("เวลา H นาฬิกา i นาที s วินาที", $timestamp);
	
	//echo "วัน $w ที่ $d เดือน $n ปี พ.ศ. $y $t"; 
	//return "$d $n $y";
	echo "วัน".$w."ที่ $d เดือน $n พ.ศ. $y";

}

function thaidate2( $eng_time )
{
    if( $eng_time instanceof Carbon\Carbon )
    {
        // dd($eng_time);
        $timestamp = $eng_time->timestamp;
    }
    else
    {
       $timestamp = strtotime($eng_time);
    }
        
     $thai_w=array("อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์");
     $thai_n=array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
     $w=$thai_w[date("w", $timestamp)];
     $d=date("j", $timestamp);
     $n=$thai_n[date("n", $timestamp) -1];
     $y=date("Y", $timestamp) +543;
     $t=date("เวลา H นาฬิกา i นาที s วินาที", $timestamp);
    
    //echo "วัน $w ที่ $d เดือน $n ปี พ.ศ. $y $t"; 
    //return "$d $n $y";
    return "$d $n $y";

}

function thaidateshort( $eng_time )
{
    if( $eng_time instanceof Carbon\Carbon )
    {
        // dd($eng_time);
        $timestamp = $eng_time->timestamp;
    }
    else
    {
       $timestamp = strtotime($eng_time);
    }
        
     $thai_w=array("อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์");
     $thai_n=array("ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
     $w=$thai_w[date("w", $timestamp)];
     $d=date("j", $timestamp);
     $n=$thai_n[date("n", $timestamp) -1];
     $y=date("Y", $timestamp) +543;
     $t=date("เวลา H นาฬิกา i นาที s วินาที", $timestamp);
    
    //echo "วัน $w ที่ $d เดือน $n ปี พ.ศ. $y $t"; 
    //return "$d $n $y";
    return "$d $n $y";

}

function num2thai($number)
{
    $t1           = array(
        "ศูนย์",
        "หนึ่ง",
        "สอง",
        "สาม",
        "สี่",
        "ห้า",
        "หก",
        "เจ็ด",
        "แปด",
        "เก้า"
    );
    $t2           = array(
        "เอ็ด",
        "ยี่",
        "สิบ",
        "ร้อย",
        "พัน",
        "หมื่น",
        "แสน",
        "ล้าน"
    );
    $zerobahtshow = 0; // ในกรณีที่มีแต่จำนวนสตางค์ เช่น 0.25 หรือ .75 จะให้แสดงคำว่า ศูนย์บาท หรือไม่ 0 = ไม่แสดง, 1 = แสดง
    (string) $number;
    $number = explode(".", $number);
    if (!empty($number[1])) {
        if (strlen($number[1]) == 1) {
            $number[1] .= "0";
        } elseif (strlen($number[1]) > 2) {
            if ($number[1]{2} < 5) {
                $number[1] = substr($number[1], 0, 2);
            } else {
                $number[1] = $number[1]{0} . ($number[1]{1} + 1);
            }
        }
    }
    for ($i = 0; $i < count($number); $i++) {
        $countnum[$i] = strlen($number[$i]);
        if ($countnum[$i] <= 7) {
            $var[$i][] = $number[$i];
        } else {
            $loopround = ceil($countnum[$i] / 6);
            for ($j = 1; $j <= $loopround; $j++) {
                if ($j == 1) {
                    $slen = 0;
                    $elen = $countnum[$i] - (($loopround - 1) * 6);
                } else {
                    $slen = $countnum[$i] - ((($loopround + 1) - $j) * 6);
                    $elen = 6;
                }
                $var[$i][] = substr($number[$i], $slen, $elen);
            }
        }
        $nstring[$i] = "";
        for ($k = 0; $k < count($var[$i]); $k++) {
            if ($k > 0)
                $nstring[$i] .= $t2[7];
            $val      = $var[$i][$k];
            $tnstring = "";
            $countval = strlen($val);
            for ($l = 7; $l >= 2; $l--) {
                if ($countval >= $l) {
                    $v = substr($val, -$l, 1);
                    if ($v > 0) {
                        if ($l == 2 && $v == 1) {
                            $tnstring .= $t2[($l)];
                        } elseif ($l == 2 && $v == 2) {
                            $tnstring .= $t2[1] . $t2[($l)];
                        } else {
                            $tnstring .= $t1[$v] . $t2[($l)];
                        }
                    }
                }
            }
            if ($countval >= 1) {
                $v = substr($val, -1, 1);
                if ($v > 0) {
                    if ($v == 1 && $countval > 1 && substr($val, -2, 1) > 0) {
                        $tnstring .= $t2[0];
                    } else {
                        $tnstring .= $t1[$v];
                    }
                }
            }
            $nstring[$i] .= $tnstring;
        }
    }
    $rstring = "";
    if (!empty($nstring[0]) || $zerobahtshow == 1 || empty($nstring[1])) {
        if ($nstring[0] == "")
            $nstring[0] = $t1[0];
        $rstring .= $nstring[0] . "บาท";
    }
    if (count($number) == 1 || empty($nstring[1])) {
        $rstring .= "ถ้วน";
    } else {
        $rstring .= $nstring[1] . "สตางค์";
    }
    return $rstring;
}

function thaibaht($baht)
{
    return num2thai($baht);
}
