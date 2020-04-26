<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ChartDataController extends Controller
{
    function getAllMonths(){

        $month_array = array();
        $users_dates = User::orderBy('created_at', 'ASC')->pluck('created_at');
        $users_dates = json_decode($users_dates);

        if (! empty($users_dates)) {
            foreach ($users_dates as $unformatted_date) {
                $date = new  \DateTime($unformatted_date);
                $month_no = $date->format('m');
                $month_name = $date->format('M');
                $month_array[$month_no] = $month_name;
            }
        }
        return $month_array;
    }

    function getMonthlyUserCount( $month ) {
        $monthly_user_count = User::whereMonth( 'created_at', $month )->get()->count();
        return $monthly_user_count;
    }

    function getMonthlyUserData() {

        $monthly_user_count_array = array();
        $month_array = $this->getAllMonths();
        $month_name_array = array();
        if ( ! empty( $month_array ) ) {
            foreach ( $month_array as $month_no => $month_name ){
                $monthly_user_count = $this->getMonthlyuserCount( $month_no );
                array_push( $monthly_user_count_array, $monthly_user_count );
                array_push( $month_name_array, $month_name );
            }
        }

        $max_no = max( $monthly_user_count_array );
        $max = round(( $max_no + 10/2 ) / 10 ) * 10;
        $monthly_user_data_array = array(
            'months' => $month_name_array,
            'post_count_data' => $monthly_user_count_array,
            'max' => $max,
        );

        return $monthly_user_data_array;

    }
}
