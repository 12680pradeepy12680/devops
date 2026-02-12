<?php /*
*
*Template Name: testing
*
*/ 
  
 ?>

<!DOCTYPE html>
<html>
<head>
    <title>Expiry Validation</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { font-family: Arial; padding: 20px; }
        input { padding: 10px; font-size: 18px; width: 160px; }
        .error { color: red; margin-top: 6px; }
    </style>
</head>
<body>

<h3>Credit Card Expiry Input</h3>

<form id="cardForm">
    <input type="text" id="expiry" maxlength="5" placeholder="MM/YY" autocomplete="off">
    <div id="err" class="error"></div>
    <br><br>
    <button type="submit">Submit</button>
</form>

<script>
$(document).ready(function () {

    $("#expiry").on("input", function () {
        let v = this.value;
        v = v.replace(/[^0-9\/]/g, "");
        if (v.length === 2 && !v.includes("/")) {
            v = v + "/";
        }
        if (v.length > 5) {
            v = v.substring(0, 5);
        }
        this.value = v;
    });

    $("#cardForm").on("submit", function (e) {
        e.preventDefault();
        $("#err").text("");

        let exp = $("#expiry").val();

        if (!/^\d{2}\/\d{2}$/.test(exp)) {
            $("#warningMsg").text("Please enter the expiry date in MM/YY format.");
            return;
        }

        let [MM, YY] = exp.split("/");
        let month = parseInt(MM);
        let fullYear = 2000 + parseInt(YY);

        if (month < 1 || month > 12) {
            $("#warningMsg").text("The month you entered is not valid.");
            return;
        }

        // Current date
        let now = new Date();
        let cm = now.getMonth() + 1;
        let cy = now.getFullYear();

        if (fullYear < cy || (fullYear === cy && month < cm)) {
            $("#warningMsg").text("This card is expired. Please use a valid card to proceed.");
            return;
        }

        alert(`${MM}/${fullYear}`);
    });

});
</script>

</body>
</html>
