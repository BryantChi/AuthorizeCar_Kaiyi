<?php

namespace App\Repositories\Admin;

use App\Models\Admin\DetectionReport as Model;
use Carbon\Carbon;

class DetectionReportRepository {

    const NEW = 1; // 新建資料 (暫時用不到)
    const UNDELIVERY = 2; // 未送件
    const DELIVERY = 3; // 已送件
    const REPLIED = 4; // 已回函
    const AUTHORIZATION = 5; // 可開立授權
    const REACH_LIMIT_280 = 6; // 即將達上限
    const OUT_OF_TIME = 7; // 即將到期
    const WAIT_FOR_POSTPONE = 8; // 待展延
    const WAIT_FOR_MOVE_OUT = 9; // 待移出
    const POSTPONE = 10; // 已展延 (暫時用不到)
    const REACH_300 = 11; // 已達上限 (暫時用不到)
    const MOVE_OUT = 12; // 已移出
    const ACTION_FOR_MOVE_OUT = 13; // 移出
    const ACTION_FOR_POSTPONE = 14; // 展延
    const DEACTIVATED = 15; // 已停用


    public static function getAllDetectionReports() {

        $model = Model::all();

        return $model;
    }

    public static function autoCheckAuthorizedStatus() {

        $today = Carbon::now();

        $detectionReports = Model::all();

        foreach ($detectionReports as $value) {
            $dr = Model::find($value->id);

            $reports_expiration_date_end = Carbon::parse($dr->reports_expiration_date_end);

            if ($dr->reports_authorize_status == self::REPLIED) {
                $dr->reports_authorize_status = self::AUTHORIZATION;

                if ($today >= $reports_expiration_date_end) {
                    $dr->reports_authorize_status = self::ACTION_FOR_POSTPONE;
                    $dr->save();
                    continue;
                }

                if ($today >= $reports_expiration_date_end->subMonths(2)) {
                    $dr->reports_authorize_status = self::OUT_OF_TIME;
                    $dr->save();
                    continue;
                }

                if ($dr->reports_authorize_count_current >= 300) {
                    $dr->reports_authorize_status = self::ACTION_FOR_MOVE_OUT;
                    $dr->save();
                    continue;
                }

                if ($dr->reports_authorize_count_current >= 280) {
                    $dr->reports_authorize_status = self::REACH_LIMIT_280;
                    $dr->save();
                    continue;
                }

                $dr->save();
                continue;
            }

            if ($dr->reports_authorize_status == self::WAIT_FOR_MOVE_OUT) {
                $dr->reports_authorize_status = self::ACTION_FOR_MOVE_OUT;

                if ($dr->reports_authorize_count_current >= 300) {
                    $dr->reports_authorize_status = self::ACTION_FOR_MOVE_OUT;
                    $dr->save();
                    continue;
                }

                if ($dr->reports_authorize_count_current >= 280) {
                    $dr->reports_authorize_status = self::REACH_LIMIT_280;
                    $dr->save();
                    continue;
                }

                if ($today >= $reports_expiration_date_end) {
                    $dr->reports_authorize_status = self::ACTION_FOR_POSTPONE;
                    $dr->save();
                    continue;
                }

                if ($today >= $reports_expiration_date_end->subMonths(2)) {
                    $dr->reports_authorize_status = self::OUT_OF_TIME;
                    $dr->save();
                    continue;
                }

                $dr->save();
                continue;
            }

            if ($dr->reports_authorize_status == self::WAIT_FOR_POSTPONE) {
                $dr->reports_authorize_status = self::ACTION_FOR_POSTPONE;

                if ($today >= $reports_expiration_date_end) {
                    $dr->reports_authorize_status = self::ACTION_FOR_POSTPONE;
                    $dr->save();
                    continue;
                }

                if ($today >= $reports_expiration_date_end->subMonths(2)) {
                    $dr->reports_authorize_status = self::OUT_OF_TIME;
                    $dr->save();
                    continue;
                }

                if ($dr->reports_authorize_count_current >= 300) {
                    $dr->reports_authorize_status = self::ACTION_FOR_MOVE_OUT;
                    $dr->save();
                    continue;
                }

                if ($dr->reports_authorize_count_current >= 280) {
                    $dr->reports_authorize_status = self::REACH_LIMIT_280;
                    $dr->save();
                    continue;
                }

                $dr->save();
                continue;
            }

            if ($today >= $reports_expiration_date_end) {
                $dr->reports_authorize_status = self::ACTION_FOR_POSTPONE;
                $dr->save();
                continue;
            }

            if ($today >= $reports_expiration_date_end->subMonths(2)) {
                $dr->reports_authorize_status = self::OUT_OF_TIME;
                $dr->save();
                continue;
            }

            if ($dr->reports_authorize_count_current >= 300) {
                $dr->reports_authorize_status = self::ACTION_FOR_MOVE_OUT;
                $dr->save();
                continue;
            }

            if ($dr->reports_authorize_count_current >= 280) {
                $dr->reports_authorize_status = self::REACH_LIMIT_280;
                $dr->save();
                continue;
            }


        }

        return true;

    }

}
