<?php
include('Wlredis.php');
$redis=new Wlredis();



$server = new swoole_websocket_server("0.0.0.0", 8811);

$server->set([

    'enable_static_handler'=>true,
    'document_root'=>"/www/wwwroot/shanghai",
]);


$server->on('open', function (swoole_websocket_server $server, $request) {

    $fd=$request->fd;
    echo "������$fd";
    $GLOBALS['fd'][$fd] =$fd;
    $arr=[];
    $arr['id']=$fd;
    $arr['type']="id";
    //�ж�Redis������û�ж���
    $redis=new Wlredis();
    $temp_arr=$redis->get("msg");
    
    if($temp_arr!=null){
        echo "Redis������";
        $arr['redis']=json_decode($temp_arr);
    }else{
        echo "��ôû��!";
    }
    $server->push($fd,json_encode($arr));

    
});
 
    $server->on('message', function (swoole_websocket_server $server, $frame) {
        global $client;
        $data = $frame->data;
    
        $arr = json_decode($data,true);
        
        $temp=[];
        $temp['type']="data";
        $temp['id']=$arr[0];
        $temp['context']=$arr[1];
        $temp['tou']=$arr[2];
        $temp['name']=$arr[3];
        
        var_dump($temp);
        
        $redis=new Wlredis();
        $temp_arr=$redis->get("msg");
        
        //����һ��������
        $arr_null=[];
        if($temp_arr==null){
            $arr_null[]=$temp;
            $redis->set("msg",json_encode($arr_null));
        }else{
            $temp_arr=json_decode($temp_arr);
            $temp_arr[]=$temp;
            $redis->set("msg",json_encode($temp_arr));
        }
       
       
//         var_dump($redis_arr);
       
        
        foreach($GLOBALS['fd'] as $aa){

            $server->push($aa,json_encode($temp));

        }
        
    });
        
        $server->on('close', function ($ser, $fd) {
            unset($GLOBALS['fd'][$fd]);
            
        });
            
      $server->start();
