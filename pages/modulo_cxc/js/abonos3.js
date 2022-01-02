var cuotaCable = document.getElementById("cuotaCable").value;
var cuotaInter = document.getElementById("cuotaInter").value;

var cesc = document.getElementById("aplicarCesc").value;
document.getElementById("cesc").value = cesc;

var radios = document.getElementsByName('aplicarCesc');

function getCesc(){
    for (var i = 0, length = radios.length; i < length; i++)
    {
     if (radios[i].checked == true)
     {
      document.getElementById("cesc").value = radios[i].value;
      break;
     }
    }
}

if (document.getElementById("servicio").value == "c") {
    document.getElementById("valorCuota").value = cuotaCable;
}else if (document.getElementById("servicio").value == "i") {
    document.getElementById("valorCuota").value = cuotaInter;
}

function getValorCobrador(){
    if (document.getElementById("servicio").value == "i") {
        document.getElementById("valorCuota").value = cuotaInter;
    }else if (document.getElementById("servicio").value == "c") {
        document.getElementById("valorCuota").value = cuotaCable;
    }
    var codValue = document.getElementById("codigoCliente").value;
    var servicio = document.getElementById("servicio").value;
    var cobrador = document.getElementById("cobrador").value;
    // Trigger the button element with a click
    window.location="abonos.php?codigoCliente="+codValue+"&tipoServicio="+servicio+"&cobrador="+cobrador;
}


function getValorCuota(){
    if (document.getElementById("servicio").value == "i") {
        document.getElementById("valorCuota").value = cuotaInter;
    }else if (document.getElementById("servicio").value == "c") {
        document.getElementById("valorCuota").value = cuotaCable;
    }
    var codValue = document.getElementById("codigoCliente").value;
    var servicio = document.getElementById("servicio").value;
    var cobrador = document.getElementById("cobrador").value;
    // Trigger the button element with a click
    window.location="abonos.php?codigoCliente="+codValue+"&tipoServicio="+servicio+"&cobrador="+cobrador;
}

function getMesesPagar(){
    if (document.getElementById("mesx1") != null && document.getElementById("mesx2") == null){
        if (document.getElementById("mesx1").checked == true) {
            var mes1 = document.getElementById("mesx1value").value;
            document.getElementById("totalPagar").value = parseFloat(mes1);
            var mesCargo1 = document.getElementById("mesCargo1").value;
            document.getElementById("meses").value = mesCargo1;
            var total = document.getElementById("totalPagar").value;
            var cesc = document.getElementById("cesc").value;
            totalSinIva = String(parseFloat(total)/1.13).substring(0, 5);
            document.getElementById("impSeg").value = String(parseFloat(cesc)*parseFloat(totalSinIva)).substring(0, 4);
            var impSeg = document.getElementById("impSeg").value;
            document.getElementById("totalAbonoImpSeg").value = String(parseFloat(total)+parseFloat(impSeg)).substring(0, 5);
            cargoTotal = document.getElementById("totalAbonoImpSeg").value = String(parseFloat(total)+parseFloat(impSeg)).substring(0, 5);
            document.getElementById("total").value = cargoTotal;
            //CAMBIOS ACÁ
            var pendiente = document.getElementById("pendiente").value;
            document.getElementById("pendiente").value = parseFloat(pendiente) - parseFloat(total);
        }else {
            var mes1 = document.getElementById("mesx1value").value;
            document.getElementById("totalPagar").value = "0.0";
            var mesCargo1 = document.getElementById("mesCargo1").value;
            document.getElementById("meses").value = "";
            var cesc = document.getElementById("impSeg").value = "0.0 ";
            document.getElementById("totalAbonoImpSeg").value = "0.0";
            document.getElementById("total").value = "0.0";
            var total = document.getElementById("totalPagar").value;
            var cesc = document.getElementById("cesc").value;
            totalSinIva = String(parseFloat(total)/1.13).substring(0, 5);
            document.getElementById("impSeg").value = String(parseFloat(cesc)*parseFloat(totalSinIva)).substring(0, 4);
            var impSeg = document.getElementById("impSeg").value;
            document.getElementById("totalAbonoImpSeg").value = String(parseFloat(total)+parseFloat(impSeg)).substring(0, 5);
            cargoTotal = document.getElementById("totalAbonoImpSeg").value = String(parseFloat(total)+parseFloat(impSeg)).substring(0, 5);
            var saldoActual = document.getElementById("saldoActual0").value;
            console.log(saldoActual);
            var saldoActualSinIva = String(parseFloat(saldoActual)/1.13).substring(0, 5);
            console.log(saldoActualSinIva);
            var impuesto = String(parseFloat(saldoActualSinIva)*parseFloat(cesc)).substring(0, 4);
            console.log(impuesto);
            document.getElementById("pendiente").value = saldoActual;
        }
    }else if (document.getElementById("mesx1") != null && document.getElementById("mesx2") != null) {
        if (document.getElementById("mesx1").checked == true && document.getElementById("mesx2").checked == false) {
            var mes1 = document.getElementById("mesx1value").value;
            var mes2 = document.getElementById("mesx2value").value;
            document.getElementById("totalPagar").value = parseFloat(mes1);
            var total = document.getElementById("totalPagar").value;
            var cesc = document.getElementById("cesc").value;
            totalSinIva = String(parseFloat(total)/1.13).substring(0, 5);
            console.log(totalSinIva);
            document.getElementById("impSeg").value = String(parseFloat(cesc)*parseFloat(totalSinIva)).substring(0, 4);
            var impSeg = document.getElementById("impSeg").value;
            console.log(impSeg);
            document.getElementById("totalAbonoImpSeg").value = String(parseFloat(total)+parseFloat(impSeg)).substring(0, 5);
            cargoTotal = document.getElementById("totalAbonoImpSeg").value = String(parseFloat(total)+parseFloat(impSeg)).substring(0, 5);
            document.getElementById("total").value = cargoTotal;
            var mes2SinIva = (parseFloat(mes2)/1.13);
            var impSegMes2 = (parseFloat(cesc)*parseFloat(mes2SinIva));
            document.getElementById("pendiente").value = String(parseFloat(mes2)).substring(0, 5);
            var mesCargo1 = document.getElementById("mesCargo1").value;
            //document.getElementById("pendiente").value = mes2;
            document.getElementById("meses").value = mesCargo1;

            document.getElementById("meses").value = mesCargo1;
        }else if (document.getElementById("mesx1").checked == true && document.getElementById("mesx2").checked == true) {
            var mes1 = document.getElementById("mesx1value").value;
            var mes2 = document.getElementById("mesx2value").value;
            document.getElementById("totalPagar").value = parseFloat(mes1) + parseFloat(mes2);
            var total = document.getElementById("totalPagar").value;
            var cesc = document.getElementById("cesc").value;
            console.log(total);
            var totalSinIvaMesx1 = String(parseFloat(mes1)/1.13).substring(0, 5);
            var totalSinIvaMesx2 = String(parseFloat(mes2)/1.13).substring(0, 5);
            var totalSinIva = parseFloat(totalSinIvaMesx1) + parseFloat(totalSinIvaMesx2);
            var impSegx1 = String(parseFloat(cesc)*parseFloat(totalSinIvaMesx1)).substring(0, 4);
            var impSegx2 = String(parseFloat(cesc)*parseFloat(totalSinIvaMesx2)).substring(0, 4);
            var impSegTotal = parseFloat(impSegx1) + parseFloat(impSegx2);
            console.log(impSegTotal);
            var cargoTotal = parseFloat(total) + parseFloat(impSegTotal);
            console.log(cargoTotal);

            var mesCargo1 = document.getElementById("mesCargo1").value;
            var mesCargo2 = document.getElementById("mesCargo2").value;
            document.getElementById("meses").value = mesCargo1+","+mesCargo2;
            document.getElementById("impSeg").value = impSegTotal;
            var impSeg = document.getElementById("impSeg").value;
            document.getElementById("totalAbonoImpSeg").value = String(parseFloat(total)+parseFloat(impSeg)).substring(0, 5);
            //cargoTotal = document.getElementById("totalAbonoImpSeg").value = String(parseFloat(totalSinIva)+parseFloat(impSeg)).substring(0, 5);
            document.getElementById("total").value = cargoTotal;
            //CAMBIOS ACÁ
            var pendiente = document.getElementById("pendiente").value;
            document.getElementById("pendiente").value = parseFloat(pendiente) - parseFloat(total) + parseFloat(mes2);

        }else {
            document.getElementById("totalPagar").value = "0.0";
            document.getElementById("impSeg").value = "0.0";
            document.getElementById("totalAbonoImpSeg").value = "0.0";
            document.getElementById("total").value = "0.0";
            var cesc = document.getElementById("cesc").value;
            var saldoActual = document.getElementById("saldoActual0").value;
            console.log(saldoActual);
            document.getElementById("pendiente").value = saldoActual;
            var totalSinIvaSaldo = String(parseFloat(saldoActual)/1.13).substring(0, 5);
            var impuestoSeg = String(parseFloat(cesc)*parseFloat(totalSinIvaSaldo)).substring(0, 4);
            document.getElementById("pendiente").value = String(parseFloat(saldoActual)).substring(0, 5);
            document.getElementById("meses").value = "";

        }
    }
}

if ((document.getElementById("mesx1") != null && document.getElementById("mesx2") == null) || (document.getElementById("mesx1") == null && document.getElementById("mesx2") == null)) {
    //console.log(document.getElementById("mesx1"));
    //console.log(document.getElementById("xmeses"));
    document.getElementById("xmeses").style.display = "";
}

function xmesesCancelar(){
    if (document.getElementById("mesx1") != null && document.getElementById("mesx2") != null){
        var nextM = (document.getElementById("meses").value).substring(0,7);
        //console.log("valor de meses "+nextM);
        nextM = nextM.replace("/", "-");
        var joinArray = nextM.split("-").reverse().join("-");

        var d = new Date(joinArray+'T00:00');
        console.log("valor de joinArray "+joinArray);
        console.log("valor de Date joinArray "+d);
        var xmeses = document.getElementById("xmeses").value;

        //d.setMonth(d.getMonth());
        var newDate = new Date(d.setMonth(d.getMonth()+1));
        //var month = (newDate.getMonth())+2;
        //console.log("FUERA DEL LOOP "+newDate.getMonth());
        var vueltas = 2;
        for (var i = 1; i < xmeses; i++) {
            //console.log("EN EL LOOP "+newDate.getMonth());
            //var newDate = new Date(d.setMonth(d.getMonth()+2));
            if (vueltas == 1) {
                console.log("MES MES MES d"+d.getMonth());
                console.log("MES MES MES newDate "+newDate.getMonth());

                var mm = String(newDate.getMonth() + i).padStart(2, '0'); //January is 0!
                console.log("MES antes de comparar "+mm);
                //console.log(newDate2);
                var yyyy = newDate.getFullYear();

            }else {
                var mm = String(newDate.getMonth() + i).padStart(2, '0'); //January is 0!
                console.log("MES antes de comparar "+mm);
                //console.log(newDate2);
                var yyyy = yyyy;
            }


            if (mm >12) {
                if (mm == 13) {
                    mm=1;
                    yyyy = newDate2.getFullYear()+1;
                    console.log("EL AÑO ACTUAL ES: "+newDate2.getFullYear());
                }else if (mm == 14) {
                    mm=2;
                    console.log("EL AÑO ACTUAL ES: "+newDate2.getFullYear());
                    yyyy = yyyy;
                }else if (mm == 15) {
                    mm=3;
                    console.log("EL AÑO ACTUAL ES: "+newDate2.getFullYear());
                    yyyy = yyyy;
                }else if (mm == 16) {
                    mm=4;
                    console.log("EL AÑO ACTUAL ES: "+newDate2.getFullYear());
                    yyyy = yyyy;
                }else if (mm == 17) {
                    mm=5;
                    yyyy = yyyy;
                }else if (mm == 18) {
                    mm=6;
                    yyyy = yyyy;
                }else if (mm == 19) {
                    mm=7;
                    yyyy = yyyy;
                }else if (mm == 20) {
                    mm=8;
                    yyyy = yyyy;
                }
                //mm = 1; //January is 0!
                //yyyy = newDate2.getFullYear()+1;
            }
            console.log("MES despues de comparar "+mm);

            date = mm + '/' + yyyy;

            console.log(date);
            var beforeDate = "";
            if (i >= 1) {
                //console.log("MES SIN SUMAR 1 "+newDate.getMonth());

                if (mm < 10) {
                    console.log("LONGITUD DE CADENA "+mm.toString.length);
                    if (mm.toString.length == 1) {
                        var newDate2 = yyyy + "-" + "0"+mm;
                        console.log("DENTRO DE CONDICIÓN "+mm);
                    }else {
                        var newDate2 = yyyy + "-" + mm;
                        console.log("FUERA DE CONDICIÓN "+mm);
                    }
                }else {
                    var newDate2 = yyyy + "-" + mm;
                    console.log("FUERA DE CONDICIÓN FINAL "+mm);
                }
                //console.log("nueva fecha fecha "+newDate.toLocaleDateString());
                newDate2 = newDate2.split("-").reverse().join("-");
                //console.log("MES SUMANDO 1 "+newDate2);
                beforeDate = document.getElementById("meses").value;
                //console.log(beforeDate);
                document.getElementById("meses").value = (newDate2 + "," + beforeDate).replace("-", "/");

                var month = month+i;
                var xxx = newDate2.split("-").reverse().join("-");
                console.log("PRUEBAAAA "+xxx);

                newDate2 = new Date(xxx);
                console.log("VIENDO "+newDate2);
                vueltas++;

            }

        }
    }
    else {
        var nextM = (document.getElementById("meses").value).substring(0,7);
        //console.log("valor de meses "+nextM);
        nextM = nextM.replace("/", "-");
        var joinArray = nextM.split("-").reverse().join("-");

        var d = new Date(joinArray+'T00:00');
        console.log("valor de joinArray "+joinArray);
        console.log("valor de Date joinArray "+d);
        var xmeses = document.getElementById("xmeses").value;
        //d.setMonth(d.getMonth());
        var newDate = new Date(d.setMonth(d.getMonth()+1));
        //var month = (newDate.getMonth())+2;
        //console.log("FUERA DEL LOOP "+newDate.getMonth());
        var vueltas = 1;
        for (var i = 1; i < xmeses; i++) {
            //console.log("EN EL LOOP "+newDate.getMonth());
            //var newDate = new Date(d.setMonth(d.getMonth()+2));
            if (vueltas == 1) {
                console.log("MES MES MES d"+d.getMonth());
                console.log("MES MES MES newDate "+newDate.getMonth());

                var mm = String(newDate.getMonth() + i).padStart(2, '0'); //January is 0!
                console.log("MES antes de comparar "+mm);
                //console.log(newDate2);
                var yyyy = newDate.getFullYear();

            }else {
                var mm = String(newDate.getMonth() + i).padStart(2, '0'); //January is 0!
                console.log("MES antes de comparar "+mm);
                //console.log(newDate2);
                var yyyy = yyyy;
            }


            if (mm >12) {
                if (mm == 13) {
                    mm=1;
                    yyyy = newDate2.getFullYear()+1;
                    console.log("EL AÑO ACTUAL ES: "+newDate2.getFullYear());
                }else if (mm == 14) {
                    mm=2;
                    console.log("EL AÑO ACTUAL ES: "+newDate2.getFullYear());
                    yyyy = yyyy;
                }else if (mm == 15) {
                    mm=3;
                    console.log("EL AÑO ACTUAL ES: "+newDate2.getFullYear());
                    yyyy = yyyy;
                }else if (mm == 16) {
                    mm=4;
                    console.log("EL AÑO ACTUAL ES: "+newDate2.getFullYear());
                    yyyy = yyyy;
                }else if (mm == 17) {
                    mm=5;
                    yyyy = yyyy;
                }else if (mm == 18) {
                    mm=6;
                    yyyy = yyyy;
                }else if (mm == 19) {
                    mm=7;
                    yyyy = yyyy;
                }else if (mm == 20) {
                    mm=8;
                    yyyy = yyyy;
                }
                //mm = 1; //January is 0!
                //yyyy = newDate2.getFullYear()+1;
            }
            console.log("MES despues de comparar "+mm);

            date = mm + '/' + yyyy;

            console.log(date);
            var beforeDate = "";
            if (i >= 1) {
                //console.log("MES SIN SUMAR 1 "+newDate.getMonth());

                if (mm < 10) {
                    console.log("LONGITUD DE CADENA "+mm.toString.length);
                    if (mm.toString.length == 1) {
                        var newDate2 = yyyy + "-" + "0"+mm;
                        console.log("DENTRO DE CONDICIÓN "+mm);
                    }else {
                        var newDate2 = yyyy + "-" + mm;
                        console.log("FUERA DE CONDICIÓN "+mm);
                    }
                }else {
                    var newDate2 = yyyy + "-" + mm;
                    console.log("FUERA DE CONDICIÓN FINAL "+mm);
                }
                //console.log("nueva fecha fecha "+newDate.toLocaleDateString());
                newDate2 = newDate2.split("-").reverse().join("-")
                //console.log("MES SUMANDO 1 "+newDate2);
                beforeDate = document.getElementById("meses").value;
                //console.log(beforeDate);
                document.getElementById("meses").value = (newDate2 + "," + beforeDate).replace("-", "/");

                var month = month+i;
                var xxx = newDate2.split("-").reverse().join("-");
                console.log("PRUEBAAAA "+xxx);

                newDate2 = new Date(xxx);
                console.log("VIENDO "+newDate2);
                vueltas++;

                // CALCULO PARA MOSTRAR EL TOTAL A PAGAR
                var cesc = document.getElementById("cesc").value;
                totalSinIva = String(parseFloat(document.getElementById("valorCuota").value)/1.13);//.substring(0, 10);
                var impuestox = String(parseFloat(cesc)*parseFloat(totalSinIva)).substring(0, 4);

                var totalPagar1 = document.getElementById("xmeses").value*parseFloat(document.getElementById("valorCuota").value);
                document.getElementById("totalPagar").value = totalPagar1;

                //console.log(document.getElementById("impSeg").value);
                //console.log(document.getElementById("xmeses").value);
                document.getElementById("impSeg").value = Number(parseFloat(impuestox) * document.getElementById("xmeses").value).toFixed(2);
                document.getElementById("totalAbonoImpSeg").value = Number(parseFloat(totalPagar1)+parseFloat(document.getElementById("impSeg").value)).toFixed(2);
                //console.log(document.getElementById("totalPagar").value);
                //console.log(document.getElementById("xmeses").value);
                // FIN CALCULO PARA MOSTRAR EL TOTAL A PAGAR

            }

        }
    }

}
/*function imprimirAbono(){
    var r = confirm("¿Desea imprimir el comprobante de pago?");
    if (r == true) {
      document.getElementById("submitAbono").name="imprimirAbono";
      document.getElementById("submitAbono").value="1";
      document.getElementById("submitAbono").click();
    } else {
      document.getElementById("submitAbono").name="submit";
      document.getElementById("submitAbono").click();
    }
}*/

function anularTodo(){
    document.getElementById("totalPagar").value="0.00";
    document.getElementById("impSeg").value="0.00";
    document.getElementById("totalAbonoImpSeg").value="0.00";
    document.getElementById("total").value="0.00";
}
