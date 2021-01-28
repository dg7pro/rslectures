<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Demo Transaction with JS Checkout</title>
    <link rel="shortcut icon" type="image/png" href="https://developer.paytm.com/demo//static/images/icon.png?v=1.9"/>
    <link href="https://developer.paytm.com/demo//static/css/style.css?v=1.9" rel="stylesheet" />

    <script type="application/javascript" src="https://securegw.paytm.in//merchantpgpui/checkoutjs/merchants/JdmvXd39200695834227.js"></script>

</head>
<body>
<header>
    <div class="header-container">
        <a href="https://developer.paytm.com/docs/js-checkout/">
            <div class="logo">
                <span><img src="https://developer.paytm.com/demo//static/images/logo.png?v=1.9" alt="paytm logo image" /></span>
                <span class="logotext"><span>JS</span><span>Checkout</span></span>
            </div>
        </a>
    </div>

</header>
<div class="main-content">
    <div class="heading">
        <h1>Demo Transaction with JS Checkout</h1>
    </div>
    <div class="container">
        <div class="topitemDetailsBox">
            <h3 class="extra"> Shopping Cart : (1 item)</h3>
            <div class="itemDetailsBox">
                <img src="https://developer.paytm.com/demo//static/images/shirt.png?v=1.8" alt="shirt">
                <div class="item-discription">
                    <span class="itemHeading">Mock Formal Shirt</span>
                    <p class="star">
                        <span>&#9733;</span>
                        <span>&#9733;</span>
                        <span>&#9733;</span>
                        <span>&#9733;</span>
                        <span>&#9733;</span>
                    </p>
                    <p><b>Rs 1.00</b></p>
                    <p class="product-description extra">Paytm provides an end-to-end online payments solution. We accept and validate
                        Internet payments via Credit Card, Debit Card, Net-Banking,
                        UPI and popular Wallets from the end customers in real-time.</p>
                </div>
            </div>
        </div>
        <div class="topRightBox">
            <h3>Order Summary</h3>
            <div class="rightBox">
                <div class="orderDetails">
                    <div class="orderSummaryBox">
                        <p class="itemprice extra"><span>Total MRP&nbsp;<b class="greyText">(Inclusive of all charges)</b></span><span>Rs 1.00</span></p>
                        <p class="itemprice extra"><span>Discount</span><span>Rs 0.00</span></p>
                        <p class="itemprice extra"><span>Shipping Charges</span>Rs 0.00<span></span></p>
                        <p class="itemprice"><span><b>Total Amount Payable</b></span><span><b>Rs 1.00</b></span></p>
                        <button class="button" id="paytmWithPaytm">Pay with Paytm</button>
                    </div>
                </div>
                <br>
            </div>
            <p class="grayText">*This is real transaction, and the money will be auto-refunded to your account in 4-5
                days</p>
        </div>
        <!-- end of top right box -->
    </div>
</div>


<script type="text/javascript">

    document.getElementById("paytmWithPaytm").addEventListener("click", function(){
        onScriptLoad("303f1aedfabe4df7b4d000c8b88feed71611322284998","1611309833699","10.00");
    });
    function onScriptLoad(txnToken, orderId, amount) {
        var config = {
            "root": "",
            "flow": "DEFAULT",
            "merchant":{
                "name":"XYZ Enterprises",
                "logo":"https://developer.paytm.com/demo//static/images/merchant-logo.png?v=1.4"
            },
            "style":{
                "headerBackgroundColor":"#8dd8ff",
                "headerColor":"#3f3f40"
            },
            "data": {
                "orderId": orderId,
                "token": txnToken,
                "tokenType": "TXN_TOKEN",
                "amount": amount
            },
            "handler":{
                "notifyMerchant": function (eventName, data) {
                    /*if(eventName == 'SESSION_EXPIRED'){
                        alert("Your session has expired!!");
                        //location.reload();
                    }*/
                    console.log('Hello');
                }
            }
        };

        if (window.Paytm && window.Paytm.CheckoutJS) {
            // initialze configuration using init method
            window.Paytm.CheckoutJS.init(config).then(function onSuccess() {
                console.log('Before JS Checkout invoke');
                // after successfully update configuration invoke checkoutjs
                window.Paytm.CheckoutJS.invoke();
            }).catch(function onError(error) {
                console.log("Error => ", error);
            });
        }
    }
</script>

<footer>
    <div class="footer-bottom">
        <div class="lightBlue"></div>
        <div class="darkBlue"></div>
        <div class="linksdiv">
            <ul class="footerlinks">
                <li><a href="https://paytm.com/about-us/our-policies/" target="_blank">Terms of Service</li></a></li>
                <li><a href="https://paytm.com/about-us/our-policies/" target="_blank">Privacy Policy</a></li>
            </ul>
        </div>
        <div class="copyright footerlinks">
            <ul><li>© 2020, One97 Communications Pvt. Ltd</li></ul>
        </div>
    </div>
</footer>
</body>
</html>
