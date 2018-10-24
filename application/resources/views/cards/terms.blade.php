@extends('layout.main')

@section('title', 'Terms and conditions')

@section('content')
    <h2>Terms and conditions</h2>
    <h3>Please review and accept the following terms and conditions to proceed with card registration</h3>
    <div class="terms">
        <h4>1.1 AGREEMENT WITH Zeipt AS</h4>
        <p>
            The present terms and conditions apply to customer’s use and closure of Zeipt AS digital receipt services as referred to herein. By agreeing to these terms and conditions you as a customer are agreeing in letting Zeipt use it’s network/stored data and third parties to capture, process and route your digital receipt to the best of it’s abilities; limited to it’s legal form and show it to you in it’s app UI.
            Together with any other terms and conditions referred therein, they represent the legal relationship between Zeipt AS and its customers. Use of additional services requires additional terms and conditions as notified during the ordering or using such services. It will appear from the order confirmation, which establishment fee and which monthly prices the customer should pay for each service at the time of ordering and to what extent extra information is needed, processed and stored for these “so called” services.
        </p>
        <h4>1.2 RECEIPT SERVICE</h4>
        <p>
            Upon clicking the register card button, Zeipt AS makes a so-called “hosted page” from an authorized Token service provider (Verifone AS), available to its customers in connection with the entering into the present agreement. Zeipt AS is only entitled to use this “hosted page” on the pages where it’s customers enter theirs card information.

            Zeipt AS is as well entitled to show it’s customer an “success-page” and “failure-page” for the outcome of the process of the card information in the Verifone system. The use of a hosted pages on other pages is regarded as substantial violation of the agreement with the Verifone AS hosted page service.

            Once the customer's card is approved by his/her bank or it’s bank’s authorized service provider a specific token linked to Zeipts services and the card (Card Token) is created by the Verifone system and sent to Zeipt servers where this is linked to your customer id.

            Zeipt doesn’t store or have access to the credit, debit, or prepaid card numbers it’s customers have written into the “Hosted page”. Zeipt only stores a portion of its customers card numbers “Masked PAN” and the generated Zeipt token ,along with a card description, to help manage its customers cards in it’s Apps UI.
        </p>
        <h4>1.3 ZEIPT SERVICE IN THE STORE</h4>
        <div id="scrolltarget"></div>
        <p>
            When a customer uses it’s card in the store where an Verifone AS point of sale (POS) is connected to an integrated third party cashier (ECR) to Zeipt, the zeipt token will be generated and transmitted from the POS to Zeipt AS, where it will be used to see if a customer is eligible for a digital receipt. If the customer so have agreed to these terms &amp; conditions and put in the card in the hosted page on beforehand, it is eligible for digital receipt. So Zeipt AS notifieds the ECR about the current status and it will send the receipt object up to Zeipt AS so it can further process it to a digital receipt to show the customer in the App UI. No ECR third party are allowed to store the card token outside of the process of getting the card token to Zeipt and longer than the receipt have been successfully processed by Zeipt AS.
            Neither Zeipt AS nor your device sends your credit, debit, or prepaid card number or customer id in the processes around the linking, processing and routing of the digital receipt. The payment must be approved before Zeipt AS will be able to link the digital receipt to your user in the Zeipt AS App. The payment is approved by other parties such as: your bank, card issuer, or payment network and has nothing to do with Zeipt AS services.
            December 20, 2017
        </p>
        <h4>1.4 YOUR PERSONAL DATA</h4>
        <p>
            Zeipt AS retains only anonymous data from the registrering of the card and in the capturing, processing and routing of its customers receipts. Zeipt uses this data to improve its products and services, this data is as such retained in an aggregate, non-personally identifiable format only linked to the card token used in its creation and can under no circumstances be linked to the person generating the receipts in the ECR.

            To the extent that card token data is treated on behalf of the customer regarding the present agreement, Zeipt AS and Zeipt AS subcontractors, if any, only act on the reach of this agreement . Zeipt AS installs the necessary technical and organizational security measures against that information accidentally or illegally is destroyed, lost or degraded and against that it is brought to unauthorized knowledge, is misused or otherwise treated contrary to these terms and conditions.
        </p>
        <h4>1.5 TERMINATION</h4>
        <p>
            The customer party can terminate the agreement directly with the service he/she now have agreed to, after accepting these terms &amp; conditions.
            If the customer so wishes to terminate the agreement, he/she is recommended to log onto the Zeipt AS app and select ”Terminate receipt service” in the settings menu. Zeipt AS will confirm the customer’s termination by email, on the email address given by the customer’s upon creation of user in the app. Alternatively, the customer can send a written termination to Zeipts Email or it’s mail address, note that the customer must state it’s customer id in the Zeipt AS app to successfully terminate the service. Upon Termination of the receipt service, Zeipt AS will delete all the card tokens created under that user id and all of its digital receipt data, captured, processed and routed by Zeipt AS from the time of the original agreement of these terms &amp; conditions.
        </p>
        <form class="approve-form" method="GET" action={{route('register-card')}}>
            <input type="hidden" name="token" value="{{$user->session->first()->token}}">
            <button class="terms-approve" disabled>
                I agree to the terms and conditions
            </button>
        </form>
    </div>
@endsection

@section('footer')
    <script>
        (function($) {
            var curScroll = 0;
            var prevScroll = 0;
            var deltaScroll = 0;
            $(window).on('scroll', function(e) {
                prevScroll = curScroll;
                curScroll = $(window).scrollTop();
                deltaScroll = Math.abs(curScroll - prevScroll);
                var shouldShow = ($(window).height() + curScroll > $('#scrolltarget').offset().top);
                if(shouldShow) {
                    $('.terms-approve').prop('disabled', false);
                }
            });
        })(jQuery);
    </script>
@endsection