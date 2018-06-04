<?php 
$server = new swoole_websocket_server("0.0.0.0", 8811);

$server->set([

    'enable_static_handler'=>true,
    'document_root'=>"/www/wwwroot/ymh/root",
]);


$server->on('open', function (swoole_websocket_server $server, $request) {

    $fd=$request->fd;
    $GLOBALS['fd'][$fd] =$fd;
    $arr=[];
    $arr['id']=$fd;
    $arr['type']="id";
    $server->push($fd,json_encode($arr));
    
//     $new_people=[];
//     $new_people['id']=$fd;
//     $new_people['type']="new";
//     foreach($GLOBALS['fd'] as $aa){
        
//         $server->push($aa,json_encode($new_people));
        
//     }
    
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
        //Êä³ö
        var_dump($temp);
        
        foreach($GLOBALS['fd'] as $aa){

            $server->push($aa,json_encode($temp));

        }
        
    });
        
        $server->on('close', function ($ser, $fd) {
            unset($GLOBALS['fd'][$fd]);
            
        });
            
            $server->start();