<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Premio a la Excelencia Docente</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding: 0;" style="background">
  <table border="1"  cellpadding="0" cellspacing="0" width="100%" style="border-color: #ffffff;" >
    <tr>
      <td style="padding: 40px 30px 40px 30px;">
        <table align="center"  cellpadding="0" cellspacing="0" width="700"  style="border-collapse: collapse;">
          <tr>
            <!-- <td bgcolor="#ffffff" style="font-size: 0; line-height: 0; border-color: #ffffff;" height="10px" width="300px">
            </td> -->
            <td align="rigth" bgcolor="#ffffff" style="font-size: 0; line-height: 0; border-color: #70bbd9;" height="10">
              <img src="<?=asset_url();?>/img/correos/logo_foro_naranja.png" alt="" width="700" height="146" style="display: block;" />
            </td>
          </tr>
          <tr>
            <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
              <table cellpadding="0" cellspacing="0" width="100%" style="">
                <tr>
                  <td>
                    <?php echo $profesor;?>
                  </td>
                </tr>
                <tr>
                  <td>
                    <?php echo $folio;?>
                  </td>
                </tr>
                <tr>
                  <td>
                    Estimado Profesor(a)
                  </td>
                </tr>
                <tr>
                  <td>
                    <h4><br>Presente.</h4>
                    <br>
                  </td>
                </tr>
                <tr>
                  <td style="text-align:justify;">
                    El Comit&eacute; de Selecci&oacute;n de candidatos para el<b>Premio a la Excelencia Docente</b>, 
                    <b> <?php echo $total_solicitudes;?> </b>trabajos. Sin embargo, por motivos de espacio solo fue posible aceptar 
                        <?php echo $total_aceptados;?>, por lo que tenemos el agrado de comentarle que su solicitud:
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td align="center" bgcolor="#ffffff" style="line-height: 0;">
              <b><p>Atentamente</p></b><br>
              <b><p>Comit&eacute; organizador</p></b>
            </td>
          </tr>
          <tr>
            <td align="rigth" bgcolor="#ffffff" style="font-size: 0; line-height: 0; border-color: #70bbd9;" height="10">
              <img src="<?=asset_url();?>/img/correos/footer.png" alt="" width="700" height="70" style="display: block;" />

            </td>

          </tr>

        </table>
      </td>

    </tr>

  </table>
</body>
</html>
