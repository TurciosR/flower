<?php
include "_conexion.php";

$fini = "2021-11-15";
$fin = "2021-11-30";
$total_g_m = 0;
$total_e_m = 0;
$total_t_m = 0;
$total_g_m_e = 0;
$total_e_m_e = 0;
$total_t_m_e = 0;
$err = 0;
_begin();
while(strtotime($fini) <= strtotime($fin))
{
  $total_g_d = 0;
  $total_e_d = 0;
  $total_t_d = 0;
  $total_g_d_e = 0;
  $total_e_d_e = 0;
  $total_t_d_e = 0;
  $sql = _query("SELECT * FROM factura WHERE fecha='$fini' AND tipo='TICKET' ORDER BY fecha ASC");
  while ($row =_fetch_array($sql))
  {
    //echo "TIKET ".$row["numero_doc"]."<br>";
    if($row["anulada"])
    {
      $tot_g_e = 0;
      $tot_e_e = 0;
      $tot_a =  0;
    }
    else {
      $tot_g_e = $row["subtotal"];
      $tot_e_e = $row["venta_exenta"];
      $tot_a =  $row["total"];
    }
    $tot_g = 0;
    $tot_e = 0;
    $tot = 0;
    $sql_aux = _query('SELECT factura_detalle.*, producto.descripcion, producto.exento as exen FROM factura_detalle JOIN producto ON producto.id_producto=factura_detalle.id_prod_serv WHERE id_factura="'.$row["id_factura"].'"');
    while ($row_aux =_fetch_array($sql_aux))
    {
      $sql_aux_aux = _query("SELECT * FROM presentacion_producto WHERE id_pp='".$row_aux["id_presentacion"]."'");
      $datos_aux_aux = _fetch_array($sql_aux_aux);
      
      $n_precio = "Personalizado";
      if($datos_aux_aux["costo"]>0)
      {
        $min = round(($datos_aux_aux["costo"]*1.10),2);
        $subtotal = round(($row_aux["cantidad"]*$min),2);
        /************************************************/
        /************************************************/
        /************************************************/
        /************************************************/
        
        if($subtotal<$row_aux['subtotal'])
        {
            $table_aux = "factura_detalle";
            $id_detalle = $row_aux["id_factura_detalle"];
            $form_data_aux = array(
            'precio_venta' => $min,
            'subtotal' => $subtotal,
            );
            $where_aux = "id_factura_detalle='$id_detalle'";
            if(!_update($table_aux,$form_data_aux,$where_aux))
            {
            $err =1;
            }
        }
        else
        {
            $subtotal = $row_aux['subtotal'];
        }
      }

      if(!$row["anulada"])
      {
        $tot += $subtotal;
      }
      if($row_aux["exen"] == "1")
      {
        if(!$row["anulada"])
        {
          $tot_e += $subtotal;
        }
      }
      else {
        if(!$row["anulada"])
        {
          $tot_g += $subtotal;
        }
      }
    }
    /**********************************************************/
    /**********************************************************/
    /**********************************************************/
    $table = "factura";
    $id_factura = $row["id_factura"];
    $form_data = array(
      'subtotal' => $tot_g,
      'suma_gravado' => $tot_g,
      'total' => $tot,
      'venta_exenta' => $tot_e,
      'total_menos_retencion' => $tot,
    );
    $where = "id_factura='$id_factura'";
    if(!_update($table,$form_data,$where))
    {
      $err =1;
    }
    /**********************************************************/
    /**********************************************************/
    /**********************************************************/
    //echo "Total gravado anterior: $".$tot_g_e." Total gravado nuevo $".$tot_g."<br>";
    //echo "Total exento anterior: $".$tot_e_e." Total exento nuevo $".$tot_e."<br>";
    //echo "Total general anterior: $".$tot_a." Total general nuevo $".$tot."<br>";
    //echo "<br><br>";
    $total_t_d_e += $tot_a;
    $total_e_d_e += $tot_e_e;
    $total_g_d_e += $tot_g_e;
    $total_t_d += $tot;
    $total_e_d += $tot_e;
    $total_g_d += $tot_g;
    /***************************************************/
    /***************************************************/
    /*A actualizar:
    /* Factura: subtotal, suma_gravado
    /* Factura: venta_exenta
    /* Factura: total, total_menos_retencion, total
    /* Factura Detalle: precio_venta, subtotal
    /* Corte: totalt, totalgral --- totalgral = ttik+tcof+tccf+cini
    /* Corte: total_exento, total_gravado --- totalgral = ttik+tcof+tccf+cini
    /***************************************************/
    /***************************************************/
  }
  echo "DIA ".dialetras($fini)." ".ED($fini)."<br>";
  echo "Total gravado anterior: $".number_format($total_g_d_e,2,".","")." Total gravado nuevo $".number_format($total_g_d,2,".","")."<br>";
  echo "Total exento anterior: $".number_format($total_e_d_e,2,".","")." Total exento nuevo $".number_format($total_e_d,2,".","")."<br>";
  echo "Total general anterior: $".number_format($total_t_d_e,2,".","")." Total general nuevo $".number_format($total_t_d,2,".","")."<br>";
  $sql_corte = _query("SELECT * FROM controlcaja WHERE tipo_corte='Z' AND fecha_corte='$fini'");
  $datos_corte = _fetch_array($sql_corte);
  /*$total_tik = $datos_corte["totalt"];*/
  $total_f = $datos_corte["totalf"];
  $total_cf = $datos_corte["totalcf"];
  $cashinicial = $datos_corte["cashinicial"];

  $totalgral = $total_f + $total_cf + $total_t_d + $cashinicial;

  //$total_exento_e = $datos_corte["total_exento"];
  //$total_gravado_e = $datos_corte["total_gravado"];

  //$total_exento = $total_exento_e - $total_e_d_e + $total_e_d;
  //$total_gravado = $total_gravado_e - $total_g_d_e + $total_g_d;

  $total_c_t = $datos_corte["totalt"];
  echo "Total corte anterior: $".number_format($total_c_t,2,".","")." Total corte nuevo $".number_format($total_t_d,2,".","")."<br>";
  echo "<br><br>";
  echo "<br><br>";
  /**********************************************************/
  /**********************************************************/
  /**********************************************************/
  $table_corte = "controlcaja";
  $id_corte= $datos_corte["id_corte"];
  $form_data_corte = array(
    'totalt' => $total_t_d,
    'totalgral' => $totalgral,
    'cashfinal' => $totalgral,
    /*'total_exento' => $total_exento,
    'total_gravado' => $total_gravado,*/
  );
  $where_corte = "id_corte='$id_corte'";
  if(!_update($table_corte,$form_data_corte,$where_corte))
  {
    $err =1;
  }
  /**********************************************************/
  /**********************************************************/
  /**********************************************************/
  $total_t_m_e += $total_t_d_e;
  $total_e_m_e += $total_e_d_e;
  $total_g_m_e += $total_g_d_e;
  $total_t_m += $total_t_d;
  $total_e_m += $total_e_d;
  $total_g_m += $total_g_d;
  $fini = sumar_dias_Ymd($fini,1);
}
if(!$err)
{
  _commit();
  echo "OK";

}
else {
  _rollback();
  echo "NO error";
}
echo "TOTALES GENERALES <br>";
echo "Total gravado anterior: $".number_format($total_g_m_e,2,".","")." Total gravado nuevo $".number_format($total_g_m,2,".","")."<br>";
echo "Total exento anterior: $".number_format($total_e_m_e,2,".","")." Total exento nuevo $".number_format($total_e_m,2,".","")."<br>";
echo "Total general anterior: $".number_format($total_t_m_e,2,".","")." Total general nuevo $".number_format($total_t_m,2,".","")."<br>";
echo "<br><br>";
echo "<br><br>";

?>
