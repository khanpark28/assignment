<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Datetime;

class EventController extends Controller
{
    public function getMessage(Request $request) {
        if ($request->filled('record_num')) {
            $r_number = $request->record_num;
        } else {
            $r_number = 100;
        }

        if ($request->filled('f')) {
            $f_date = $request->f; 
        } else {
            $f_date = (new Datetime())->format('Y-m-d H:i:s');
        }
        $f_date_condition = 'where created_at < "' . $f_date . '"';

        if ($request->filled('s')) {
            $s_date = $request->s; 
        } else {
            $s_date = (new Datetime())->format('Y-m-d H:i:s');
        }
        $s_date_condition = 'where created_at < "' . $s_date . '"';

        if ($request->filled('d')) {
            $d_date = $request->d; 
        } else {
            $d_date = (new Datetime())->format('Y-m-d H:i:s');
        }
        $d_date_condition = 'where created_at < "' . $d_date . '"';

        if ($request->filled('m')) {
            $m_date = $request->m; 
        } else {
            $m_date = (new Datetime())->format('Y-m-d H:i:s');
        }
        $m_date_condition = 'where created_at < "' . $m_date . '"';


        $f_query = 'select concat(user_name, " followed you!") as msg, 
                        created_at,
                        `read`
                        from followers ' . $f_date_condition . ' order by created_at desc limit '. $r_number;
        $s_query = 'select concat(user_name, "(Tier", tier, ") subscribed to you!") as msg, 
                        created_at,
                        `read`
                        from subscribers ' . $s_date_condition . ' order by created_at desc limit '. $r_number;
        $d_query = 'select concat(user_name, " donated ", amount, currency, " to you!", "\n", message) as msg, 
                        created_at,
                        `read`
                        from donations ' . $d_date_condition . ' order by created_at desc limit ' . $r_number;
        $m_query = 'select concat(user_name, " bought ", item_name, " from you for ", count * price, " ", currency) as msg, 
                        created_at,
                        `read`
                        from merch_sales ' . $m_date_condition . ' order by created_at desc limit ' . $r_number;

        $followers = DB::select($f_query);
        $subscribers = DB::select($s_query);
        $donations = DB::select($d_query);
        $merchSales = DB::select($m_query);

        $ret = array();

        $f = current($followers);
        $s = current($subscribers);
        $d = current($donations);
        $m = current($merchSales);
 
        $f_last_date = "";
        $s_last_date = "";
        $d_last_date = "";
        $m_last_date = "";

        $i = 0;
        // Merge each record on 4 tables according to created_at timeline  as much as $r_number
        while ($i < $r_number){
           /*
            error_log(((array)$f)['created_at']);           
            error_log(((array)$s)['created_at']);           
            error_log(((array)$d)['created_at']);           
            error_log(((array)$m)['created_at']);           
            */
            $arr = array();
            if ($f){
                $arr['f'] = ((array)$f)['created_at'];
                $f_last_date = $arr['f'];
            }
            if ($s){
                $arr['s'] = ((array)$s)['created_at'];
                $s_last_date = $arr['s'];
            }
            if ($d){
                $arr['d'] = ((array)$d)['created_at'];
                $d_last_date = $arr['d'];
            }
            if ($m){
                $arr['m'] = ((array)$m)['created_at'];
                $m_last_date = $arr['m'];
            }

            #$arr = array('f' => ((array)$f)['created_at'], 's' => ((array)$s)['created_at'], 'd' => ((array)$d)['created_at'], 'm' => ((array)$m)['created_at']);
            if (count($arr) == 0) {
                break;
            }

            $max_val = max($arr);
            $max_key = array_search($max_val, $arr);

            if ($max_key == 'f') {
                array_push($ret, $f);
                $f = next($followers);

            } elseif( $max_key == 's') {
                array_push($ret, $s);
                $s = next($subscribers);

            } elseif( $max_key == 'd') {
                array_push($ret, $d);
                $d = next($donations);

            } elseif( $max_key == 'm') {
                array_push($ret, $m);
                $m = next($merchSales);
            }
            $i += 1;
        }

        $last_dates = array('f'=>$f_last_date, 's'=>$s_last_date, 'd'=>$d_last_date, 'm'=>$m_last_date);
        return array('data'=>$ret, 'last_dates'=>$last_dates);
    }
}
