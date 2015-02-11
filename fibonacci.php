<?php
//----------------------------------------
//        @file	fibonacci.php
//	@author	koji nakamura
//	@date	2015/02/11
//		3^Fn( Fnはフィボナッチ数列第n項 )
//		を計算する 
//----------------------------------------

//----------------------------------------
//        関数群
//----------------------------------------
/**
 @brief	フィボナッチ数列(Fn)を計算する
 @value	$n フィボナッチ数列の添字
*/
function fibonacci( $n ){
 //$n == 0 のとき以下の式では計算出来ないので例外的に抜ける
 if( $n == 0){ return 0; }
 
 //初期値
 $before = 0;
 $after = 1;

 for( $i = 1; $i < $n ; ++$i){
  $tmp = $after;
  $after = $before + $after;
//下6桁区切りをここで行う
  $after = $after % 1000000;
  $before = $tmp;
 }
 return $after;
}

/** 
 @brief	a^2,a^4,a^8....の計算ができる
 @param	$a	a^nのa
 @param	$n	a^nのn
 @note	powという関数名にするとredeclareになってしまうので関数名に_をつけている
*/
function pow2n( $a, $n ){
 while( ($n = (int)($n / 2 )) > 0){
  $a = ($a * $a) % 1000000;
 }
 return $a;
}

/**
 @brief	a^( 1 + 2 + 4 + ... )のようにして高速化したべき乗関数
 @param $a      a^nのa
 @param $n      a^nのn
 @note	powという関数名にするとredeclareになってしまうので関数名に_をつけている
*/
function pow_( $a, $n ){
 $i = 0;
 $val = 1;
 while( $n > 0 ){
  if( $n & 1 ){
   $val = ( $val * pow2n( $a, 1 << $i) ) % 1000000;
  }
  $n = $n >> 1;
  $i++;
 }
 return $val;
}

/**
 @brief	3^Fnを計算する
*/
function power_3fibo( $n ){
 $fn = fibonacci( $n );
 return pow_( 3, $fn );
}

//----------------------------------------
//	表示部
//----------------------------------------

//コマンドライン引数をnとする
$val = $argv[ 1 ];

//デバッグ---------------------
//フィボナッチ計算関数デバッグ
//echo fibonacci( $val ).PHP_EOL;

//内部関数デバッグ
//echo pow2n( 3 , $val ).PHP_EOL;

//自主定義powデバッグ
//echo pow_( 3, $val ).PHP_EOL;

//結果表示-----------------
echo power_3fibo( $val ).PHP_EOL;

?>
