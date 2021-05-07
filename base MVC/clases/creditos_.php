<?
define("gastos", 300000);
define("diasDesfase", calcularDiasDesfase());
define("impto", 0.6);
define("inscripcion", 0);
//$gastos=300000;
//$diasDesfase=calcularDiasDesfase();
//$impto=0.6;
//$inscripcion=0;

$resp=false;

//function calcularTir($rangoValores, $inversion){
//    
//    $resp=false;
//    
//    global $impto;
//    
//    foreach($rangoValores as $i=>$valor){
////        4000 / (1 + i);
//        $resp+=($valor/(pow((1+0.0243), $i)));
////        echo "(".$valor."/"."(pow((".(1+0.0243)."), ".$i."))) ";
////        echo "VA EN => ".$resp." + ";
//    }
////    echo " - ".$inversion;
////    $resp-=$inversion;
////    echo " + 7000000";
////    $resp+=7000000;
//    
//    return $resp;
//}

function calcularCae($inversion, $pie, $plazo, $valorCuota, $valorVfmg){
    
    $resp=false;
    
    $rangoValores[0]=($inversion-$pie);
    
    for($i=1;$i<=72;$i++){
        if($i<=$plazo){
            $rangoValores[$i]=(-$valorCuota);
        }else if($i<=($plazo+1)){
            $rangoValores[$i]=(-$valorVfmg);
        }else{
            $rangoValores[$i]=0;
        }
    }
    
//    $rangoValores[0]=7000000;
//    
//    for($i=1;$i<=36;$i++){
//        $rangoValores[$i]=(-225106);
//    }
//    
//    $rangoValores[$i]=(-4000000);
    
//    for($i=38;$i<=72;$i++){
//        $rangoValores[$i]=0;
//    }
    
//    print_r($rangoValores);
    
    require_once 'clases/financial_class.php';
    $f = new Financial;
    $tir=$f->IRR($rangoValores);
//    echo 'IRR: ' . $f->IRR(array(7000000,-225106,-225106,-225106,-225106,-225106,-225106,-225106,-225106,-225106,-225106,-225106,-225106,-225106,-225106,-225106,-225106,-225106,-225106,-225106,-225106,-225106,-225106,-225106,-225106,-225106,-225106,-225106,-225106,-225106,-225106,-225106,-225106,-225106,-225106,-225106,-225106,-4000000 )) . "\n";
    
//    $resp=pow((1+$tir),12)-1;
    $resp=($tir*12);
    
//    echo "TIR: ".$tir;
//    echo "CAE: ".$resp;
    
//    $tir=calcularTir($rangoValores, $inversion);
    
//    echo "TIR: ".$tir;
    
    return $resp;
}

function calcularTasa($monto){
    
    $resp=false;
    
    global $objForm;
    
    $monto=(int)($objForm->limpiarNumero($monto));
    $ufActual=0;
    
//    if($xmlSource = "http://indicador.eof.cl/xml"){
//    if($xmlSource = "http://www.greatwallmotors.cl/classes/uf.xml"){
    if($xmlSource = "http://www.4sale.cl/indicadores/indicadoresChile.xml"){
        if($xml = simplexml_load_file($xmlSource)){
            
            foreach($xml as $indicador){

                if($indicador['nombre']=="UF"){
                    $ufActual=(float)(str_replace(",",".",preg_replace("/[^0-9|^,]/","",$indicador)));
//                    echo "uf actual: ".$ufActual;
                    break;
                }
            }

//            echo "Monto: ".$monto;
//            echo "UF ACTUAL: ".$ufActual;
//            echo "UFs: ".(round($monto/$ufActual));
            if($_POST['credito']=="3"){
                $resp=2;
            }else{
                if(round($monto/$ufActual)>200){
                    $resp=2.01;
                }else{
                    $resp=2.21;
                }
            }
        }
    }else if($xmlSource = "http://indicadoresdeldia.cl/webservice/indicadores.xml"){
        if($xml = simplexml_load_file($xmlSource)){

            $xml->indicador->uf=(float)(str_replace(",",".",preg_replace("/[^0-9|^,]/","",$xml->indicador->uf)));

//            echo "Monto: ".$monto;
//            echo "UF ACTUAL: ".$xml->indicador->uf;
//            echo "UFs: ".(round($monto/$xml->indicador->uf));
            if($_POST['credito']=="3"){
                $resp=2;
            }else{
                if(round($monto/$xml->indicador->uf)>200){
                    $resp=2.01;
                }else{
                    $resp=2.21;
                }
            }
        }
    }
    
//    echo "Tasa: ".$resp;
    
    return $resp;
}

function calcularDiasDesfase(){
    
    $resp=false;
    
    $fechaVenc=0;
    $fechaCurse=0;
    
    $resp=max(array(($fechaVenc-$fechaCurse-30), 0));
//    echo "Días Desfase: ".$resp;
    
    return $resp;
}

function obtenerValorSeguro($plazo){
    
    $resp=false;
    
    $arraySeguros=array();
    
    for($i=1;$i<=72;$i++){
        
        if($i>=1 && $i<=13){
//            $arraySeguros[$i]=0.034;
            $arraySeguros[$i]=0.048;
        }else if($i>=14 && $i<=36){
//            $arraySeguros[$i]=0.036;
            $arraySeguros[$i]=0.050;
        }else if($i>=37 && $i<=59){
//            $arraySeguros[$i]=0.039;
            $arraySeguros[$i]=0.053;
        }else if($i>=60 && $i<=72){
//            $arraySeguros[$i]=0.043;
            $arraySeguros[$i]=0.057;
        }
    }
    
    if($_POST['credito']=="3"){
        $plazo+=1;
    }
    
    if(isset($arraySeguros[$plazo])){
        $resp=$arraySeguros[$plazo];
    }
    
//    echo "valor seguro: ".$resp;
    
    return $resp;
}

function calcularTasaSeguroDesgrav($plazo){
    
    $resp=false;
    
    $diasDesfase=diasDesfase;
//    echo "no se: ".((floor((30+$diasDesfase)/30))+$plazo);
    
    if($_POST['credito']=="3"){
        $resp=obtenerValorSeguro(((floor((30+$diasDesfase)/30))+$plazo));
    }else{
        $resp=obtenerValorSeguro($plazo);
    }
    
    
    return $resp;
}

function calcularMontoAFinanciar($monto, $plazo){
    
    $resp=false;
    
    $gastos=gastos;
    $inscripcion=inscripcion;
    $impto=impto;
    $tasaSegDegrav=calcularTasaSeguroDesgrav($plazo);
    
//    echo "<br/>Monto: ".$monto;
//    echo "<br/>plazo: ".$plazo;
//    echo "<br/>Tasa Degrav: ".$tasaSegDegrav;
//    echo "<br/>impto: ".$impto;
//    echo "<br/>gastos: ".$gastos;
//    echo "<br/>Porcentaje: ".(100-$impto-(100*$tasaSegDegrav));
    $resp=round((($monto+$gastos+$inscripcion)/((100-$impto-(100*$tasaSegDegrav))/100)));
    
//    echo "Monto a Financiar: ".$resp;
    
    return $resp;
}

function calcularImpuestos($monto, $plazo, $pie){
    
    $resp=false;
    $saldoPrecio=($monto-$pie);
//    echo "Saldo precio 'calcular impuesto': ".$saldoPrecio;
    $montoAFinanciar=calcularMontoAFinanciar($saldoPrecio, $plazo);
    $impto=impto;
    
    $resp=round($montoAFinanciar*($impto/100));
    
//    echo "Impuestos: ".$resp;
    
    return $resp;
}

function calcularIntDesfase($saldoPrecio, $monto, $plazo, $pie){
    
    $resp=false;
    
    $gastos=gastos;
    $diasDesfase=diasDesfase;
    $impuestos=calcularImpuestos($monto, $plazo, $pie);
    $inscripcion=inscripcion;
    $seguroDesgrav=calcularTasaSeguroDesgrav($plazo);
    $montoAFinanciar=calcularMontoAFinanciar($saldoPrecio, $plazo);
    
    if(!$tasaInteresNominal=calcularTasa($montoAFinanciar)){
        echo "false";
        exit();
    }
    
//    echo "<br/>Impuestos: ".$impuestos;
//    echo "<br/>Seguro: ".$seguroDesgrav;
//    echo "<br/>Tasa: ".$tasaInteresNominal;
//    echo "<br/>Int desfase: ".$resp;
    
    $resp=$diasDesfase*($saldoPrecio+$gastos+$impuestos+$inscripcion+$seguroDesgrav)*$tasaInteresNominal/30;
    
    return $resp;
}

function calcularCuota($plazo, $monto, $vfmg, $pie){
    
    $resp=false;
    
    $impto=impto;
    $saldoPrecio=($monto-$pie);
    $montoAFinanciar=calcularMontoAFinanciar($saldoPrecio, $plazo);
    if(!$tasaInteresNominal=calcularTasa($montoAFinanciar)){
        echo "false";
        exit();
    }
//    echo "Saldo precio 'calcular cuota': ".$saldoPrecio;
    $interesDesfase=calcularIntDesfase($saldoPrecio, $monto, $plazo, $pie);
    $valorVfmg=$monto*($vfmg/100);
//    echo "<br/>precio: ".$monto;
//    echo "<br/>Plazo: ".$plazo;
//    echo "<br/>vfmg (%): ".$vfmg;
//    echo "<br/>Valor vfmg: ".$valorVfmg;
//    echo "<br/>Pie: ".$pie;
//    echo "<br/>Tasa: ".$tasaInteresNominal;
//    echo "<br/>Saldo Precio: ".$saldoPrecio;
//    echo "<br/>Monto a financiar: ".$montoAFinanciar;
//    echo "<br/>Interes desface: ".$interesDesfase;
//    echo "<br/>parte 1: ".(pow(1+($tasaInteresNominal/100),($plazo+1)));
    $va=($montoAFinanciar+$interesDesfase-($valorVfmg/(pow(1+($tasaInteresNominal/100),($plazo+1)))));
//    echo "va: ".$va;
    $tasa = ($tasaInteresNominal/100);
    $nper = $plazo;
    
//echo "VA: ".$va;
    $resp=round($va * ( ($tasa * ( pow( 1 + $tasa , $nper) ) ) / ( pow( 1 + $tasa, $nper ) -1 ) ));
    
//    $part1 = $tasa*pow(1+$tasa,$nper);
//    $part2 = pow((1+$tasa),$nper-1);
//
//    $resp = $va*($part1/$part2);
    
//    $i = $tasaInteresNominal / 12 / 100 ;
//    $i2 = $i + 1 ;
//    $i2 = pow($i2,-$plazo) ;
//
//    $resp = round(($i * $monto) / (1 - $i2)) ;
//    echo "<br/>Cuota: ".$resp;
//    $resp=($capital * ($i * (1 + $i) ^ $n)) / (((1 + $i) ^ $n) - 1);
    return $resp;
}

//EJEMPLO INDICADORES
//$xmlSource = "http://indicadoresdeldia.cl/webservice/indicadores.xml";
//$xml = simplexml_load_file($xmlSource);
//echo $xml->moneda->dolar;
//echo $xml->moneda->euro;
//echo $xml->moneda->dolar_clp; //Dolar interbancario
//echo $xml->indicador->uf;
//echo $xml->indicador->utm;
//echo $xml->indicador->ipc
//echo $xml->bolsa->ipsa;
//$restriccion = 'RestricciÃ³n vehÃ­cular: ';
//foreach ($xml->restriccion->normal AS $normal) {
//	$restriccion.= $normal . ', ';
//}
//echo $restriccion;	

if(
    isset($_POST['credito']) && !empty($_POST['credito'])
    && isset($_POST['versionSel']) && !empty($_POST['versionSel'])
    && isset($_POST['modeloSel']) && !empty($_POST['modeloSel'])
){
    
    include("../admin/config.php");
//    include("bd.php");
//    include("formularios.php");
    
    $objForm=new formularios();
    
    $tablaBd="fichasModelos_final";
    
    if(!$resultModelo=$objForm->read("*", $tablaBd, $_POST['modeloSel'])){
        echo "false";
        $objForm->cerrarScript();
    }
    
    $gestor = fopen("http://www.dercoaccesorios.cl/catalogo/export_json.php?id_category=".$resultModelo[0]['accModeloCot'], "r");
    $salida_json = stream_get_contents($gestor);
    
    $jsonModelos = json_decode(str_replace("})","}",str_replace("({","{",$salida_json)), true);
//    $jsonModelos = json_decode(str_replace("})","}",str_replace("({","{",file_get_contents("http://www.dercoaccesorios.cl/catalogo/export_json.php?id_category=".$resultModelo[0]['accModeloCot']))), true);
//    
//$jsonModelos=json_decode(str_replace("})","}",str_replace("({","{",$salida_json)), true);
    
    $_POST['precioModelo']=0;
    
    //buscar precio de la versión del modelo
    if($result=$objForm->read("*", $tablaBd, $_POST['modeloSel'])){
        
        if(isset($result[0]['precioVersionFinal'.$_POST['versionSel']]) && !empty($result[0]['precioVersionFinal'.$_POST['versionSel']])){
            $_POST['precioModelo']=(int)$objForm->limpiarNumero($result[0]['precioVersionFinal'.$_POST['versionSel']]);
            
//            if ($result[0]['masIva-' . $_POST['versionSel']] == "2") {
////                $precioFinal = round($precioFinal * 1.19);
//                $_POST['precioModelo']= round($_POST['precioModelo']*1.19);
//            }
        }
    }
    
    $precioFinal=0;
    
    if(isset($_POST['accesorios']) && !empty($_POST['accesorios'])){
        
        $listaAccesorios=explode(",",$_POST['accesorios']);
        
        foreach($listaAccesorios as $accesorio){
            //precio total accesorios seleccionados
            $accesorio=$objForm->limpiarVariable($accesorio);

            foreach($jsonModelos as $jsonModelo){
//                echo "json: ".$jsonModelo['name']."->Accesorio: ".$accesorio;
                if($jsonModelo['name']==$accesorio){

                    $jsonModeloPrice=$precioExplode=explode(".",$jsonModelo['price']);
                    $precioFinal+=(int)$jsonModeloPrice[0];

//                    $textMail3.='<p><a style="font-weight:normal;" href="http://www.dercoaccesorios.cl/catalogo/product.php?id_product='.$jsonModelo['name'].'">'.$jsonModelo['title'].'</a></p>';
//                                                    $jsonModeloPrice=$precioExplode=explode(".",$jsonModelo['price']);
//                                                    $precioFinal+=(int)$jsonModeloPrice[0];
//                                                    $_POST['precioTotalAccesorios']+=(int)$jsonModeloPrice[0];
                }
            }
        }
    }

    $_POST['precioModelo'] = ((int)ereg_replace("[^0-9]", "", $_POST['precioModelo']))+$precioFinal;
    
    if(!empty($_POST['precioModelo'])){
    
        
//        $bd = new BD();
        
//        $tablaBd="fichasModelos_final";
//
//        if(!$resultModelo=$bd->read("*", $tablaBd, $_POST['id_modelo'])){
//            $bd->cerrarScript();
//        }

//        Cuota = (Capital * (i * (1 + i) ^ n)) / (((1 + i) ^ n) - 1)
        
//        $_POST['precioModelo']=10000000;
//        $_POST['precioModelo']=8583000;
        
        switch($_POST['credito']){

            case "1":
                $plazo=1;
                $vfmg=0;
//                $_POST['pie']=(int)$_POST['pie'];
//                if(isset($_POST['pie']) && $_POST['pie']<=(((int)$_POST['precioModelo'])*0.9)){
//                    $pie=$_POST['pie'];
//                }else{
//                    $pie=0;
//                }
                $pie=0;
                $valorVfmg=0;
//                $valorVfmg=$_POST['precioModelo']*($vfmg/100);
//                $cae=calcularCae($_POST['precioModelo'], $pie, $plazo, $_POST['precioModelo'], $valorVfmg);
                $cae=0;
                
                $resp['cuotas'][0]=1;
                $resp['pie']=$pie;
                $resp['credito']="SIN FINANCIAMIENTO";
                $resp['cuotas2']=$plazo." de ".$objForm->formatoPrecio($_POST['precioModelo']-$pie);
                $resp['vfg']=$vfmg;
                $resp['aFinanciar']=$objForm->formatoPrecio($_POST['precioModelo']);
                $resp['cae']=$cae;
            break;
        
            case "2":
                if(
                    isset($_POST['cuotas']) 
                    && ($_POST['cuotas']=="12" || $_POST['cuotas']=="24"  || $_POST['cuotas']=="36"  
                    || $_POST['cuotas']=="48"  || $_POST['cuotas']=="60"  || $_POST['cuotas']=="72")
                ){
                    $plazo=$_POST['cuotas'];
                }else{
                    $plazo=12;
                }
//                $plazo=36;
                $vfmg=0;
//                $vfmg=40;
                $_POST['pie']=(int)$objForm->limpiarNumero($_POST['pie']);
                if(isset($_POST['pie']) && !empty($_POST['pie'])){
                    if($_POST['pie']<=(((int)$_POST['precioModelo'])*0.9)){
                        $pie=round((int)$_POST['pie']);
                    }else{
                        $pie=round(((int)$_POST['precioModelo'])*0.9);
                    }
                }else{
                    $pie=0;
                }
//                $pie=3000000;
                
                $valorCuota=calcularCuota($plazo, $_POST['precioModelo'], $vfmg, $pie);
//                $valorFinalAFinanciar=($plazo*$valorCuota);
                $valorFinalAFinanciar=calcularMontoAFinanciar(($_POST['precioModelo']-$pie), $plazo);
                $valorVfmg=$_POST['precioModelo']*($vfmg/100);
                $cae=round(calcularCae($_POST['precioModelo'], $pie, $plazo, $valorCuota, $valorVfmg)*100, 2);
                
                $resp['cuotas'][0]=12;
                $resp['cuotas'][1]=24;
                $resp['cuotas'][2]=36;
                $resp['cuotas'][3]=48;
                $resp['cuotas'][4]=60;
                $resp['cuotas'][5]=72;
                $resp['pie']=$pie;
                $resp['credito']="CREDITO CONVENCIONAL";
                $resp['cuotas2']=$plazo." de ".$objForm->formatoPrecio($valorCuota);
                $resp['vfg']=$vfmg;
                $resp['aFinanciar']=$objForm->formatoPrecio($valorFinalAFinanciar);
                $resp['cae']=$cae;
            break;
        
            case "3":
                
                if(
                    isset($_POST['cuotas']) 
                    && ($_POST['cuotas']=="24"  || $_POST['cuotas']=="36")
                ){
                    $plazo=$_POST['cuotas'];
                }else{
                    $plazo=24;
                }
                
//                $plazo=36;
                if($plazo==36){
                    $vfmg=40;
                }else{
                    $vfmg=50;
                }
//                $vfmg=40;
                $_POST['pie']=(int)$objForm->limpiarNumero($_POST['pie']);
                if(isset($_POST['pie']) && !empty($_POST['pie'])){
                    if($_POST['pie']<=(((int)$_POST['precioModelo'])*0.9)){
                        $pie=round((int)$_POST['pie']);
                    }else{
                        $pie=round(((int)$_POST['precioModelo'])*0.9);
                    }
                }else{
                    $pie=0;
                }
//                $pie=3000000;
                
                $valorCuota=calcularCuota($plazo, $_POST['precioModelo'], $vfmg, $pie);
//                $valorFinalAFinanciar=($plazo*$valorCuota);
                $valorFinalAFinanciar=calcularMontoAFinanciar(($_POST['precioModelo']-$pie), $plazo);
                $valorVfmg=$_POST['precioModelo']*($vfmg/100);
                $cae=round(calcularCae($_POST['precioModelo'], $pie, $plazo, $valorCuota, $valorVfmg)*100, 2);
                
                $resp['cuotas'][0]=24;
                $resp['cuotas'][1]=36;
                $resp['pie']=$pie;
                $resp['credito']="OPCIÓN INTELIGENTE";
                $resp['cuotas2']=$plazo." de ".$objForm->formatoPrecio($valorCuota);
                $resp['vfg']=$vfmg;
                $resp['aFinanciar']=$objForm->formatoPrecio($valorFinalAFinanciar);
                $resp['cae']=$cae;
            break;
        }
    }
    echo json_encode($resp);
}
?>