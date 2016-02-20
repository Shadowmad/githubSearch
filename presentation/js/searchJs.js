$(document).ready(function(){
  $('#sandbox-container .input-daterange,#sandbox-container1 .input-daterange,#sandbox-container2 .input-daterange').datepicker({
      format: "yyyy/mm/dd",
      endDate: "+Today",
      autoclose: true,
      todayHighlight: true
  });

    $("#selectDatesFields").on("change", function(){
    /* switch (this.value) {
    //    case "beforeDates":
      //    $("#sandbox-container").addClass("visible");
          $("#sandbox-container").removeClass("noneDisplay");
          break;
        case "afterDates":
          $("#sandbox-container1").addClass("visible");
          $("#sandbox-container1").removeClass("noneDisplay");
          break;
        case "betweenDates":*/
          $("#sandbox-container2").addClass("visible");
          $("#sandbox-container2").removeClass("noneDisplay");
          //break;
    //  }
    });
});
