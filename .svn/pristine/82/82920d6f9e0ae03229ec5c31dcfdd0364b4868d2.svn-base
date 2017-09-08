<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/16
 * Time: 15:28
 */
class CrontabAction extends CommonAction {
    //回流资金
    public function returnFund() {
        $cash = M ('cash');
        $chistory = M('chistory');
        $list = $cash->where("is_done = 1 AND type = 0")->field("")->select();
        $fee = M ('fee');
        $str46 = $fee->field("str46") -> find();
        foreach($list as $buyInfo){
            $str46 = empty($str46) ? 24*3600*2 : $str46["str46"]*3600;//回流时间
            if((time() - $buyInfo["okdt"]) > $str46){
                //$fck = M('fck')->where("id=".$buyInfo["uid"])->field("")->find();
                //$fck = M('fck')->where("id=4878")->field("")->find();
                $chistoryInfo = $chistory->where("cash_id=".$buyInfo["id"])->field("")->select();
                if(empty($chistoryInfo)){
                    $chistoryInfo = $chistory->where("did = ".$buyInfo["uid"] . " AND money=" . $buyInfo["money"] . " AND type =1 AND status = 1" )->field("")->order("id asc")->select();
                }
                foreach($chistoryInfo as $chistorySub){
                    if($chistorySub["did"] == 1 || $chistorySub["did"] == 4905){
                        $chistory->where("id = " . $chistorySub["id"])->save(["status" => 0]);
                        echo date("Y-m-d H:i:s") . "处理成功";
                        echo json_encode($chistorySub);
                    }
                }
            }
        }
    }
}
?>