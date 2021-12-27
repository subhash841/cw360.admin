<style>
    h5,h6{
        letter-spacing: 1px;
    }
    .load_feeds{
        padding: 0;
        width: 40px;
        height: 40px;
        margin: 0 12px;
    }
    .page{
        background-color: white !important;
        color: #232b3c;
    }
    .page.current{
        background-color: #232b3c !important;
        color: white !important;
    }
    .pagination-container{
        padding:5% 0;
        padding-bottom: 10%;
    }
    .bottomborder{
        border-bottom:  1px solid #e0e7ea;
    }
    .blogsubject{
        font-size: 15px;
        text-transform: uppercase;
        color:#c3cad8;
        font-weight: 600;
    }
    .blogtitle{
        margin: 25px 0;
        font-size: 28px;
        font-weight: 600;
    }
    .blogdate{
        font-size: 15px;
        color:#c3cad8;
        font-weight: 500;
        margin: 15px 0;
    }
    .bloglinks{
        font-size: 18px;
        color:#c3cad8;
        font-weight: 500;
    }
    .bloglinks a{
        color: #45bce7;
    }
    .blogtext{
        font-size: 19px;

    }
    .blogimg{
        width:100%;
        height:440px;
    }



</style>

<style>
    .mtb3{

    }
    blockquote {

        font-style: italic;
        margin: 0.25em 0;
        padding: 0.35em 40px;
        line-height: 1.45;
        position: relative;
        color: #383838;
        border-left: none;
    }

    blockquote:before {
        font-family: poppins,sans-serif;
        display: block;
        padding-left: 10px;
        content: open-quote;
        font-size: 180px;
        position: absolute;
        left: -20px;
        top: -20px;
        color: #eff2f8;
    }
    blockquote:after {
        font-family: poppins,sans-serif;
        display: block;
        padding-left: 10px;
        content:close-quote;
        font-size: 180px;
        position: absolute;
        right: 50px;
        bottom: -20%;
        color: #eff2f8;
    }
    blockquote cite {
        color: #999999;
        font-size: 14px;
        display: block;
        margin-top: 5px;
    }

    blockquote cite:before {
        content: "\2014 \2009";
    }
    .blogtext ul li {
        list-style-type: disc;
        font-size:20px;
    }
    ul:not(.browser-default){
        padding-left: 25px;
    }
    blockquote div{
        margin: 8% 4%;
    }
    .blogcover{
        box-shadow: 0px 5px 25px #c3cad8;
        width:100%;
        height:100vh;
    }
</style>
<!--<div class="banner1" style="min-height:90vh;">
    <img src="<?= base_url() ?>images/blogs/coverblog.jpg" class="blogcover">
</div>-->
<div class="white bottomborder">
    <div class="content container" >
        <div class="row" style="padding: 20px 0;">
            <h5 class="blogsubject" style="">Politics</h5> 
            <h4 class="blogtitle" style="">Time to beat the Experts using Crowd Wisdom</h4>
            <h5 class="blogdate" style="">04 December 2017</h5>
            <div class="bloglinks" style=""><!--By <a>Subhash Chabra</a> & <a>Amitabh Tiwari</a>--></div>
            <div class="blogtext">
                <p>Election forecasts by ‘experts’ have been failing at an alarming rate. In India, our own studies have shown that exit polls can predict no more than 40% of the results accurately.  Some notable failures in India and around the world include</p>
                <ul>
                    <li>UK Opinion Polls (2017)</li>
                    <li>UP election 2017 (India)</li>
                    <li>US Presidential election (2016)</li>
                    <li>Brexit (2016)</li>
                </ul>
                <p>Experts and opinion pollsters had failed to predict numerous other elections in recent times. Nate Silver’s epic failure during the 2016 election has been publicly documented. There are numerous reasons for failure rates going up including poor survey responses, higher swing vote, impact of social media on voter turn out and voting intention and so on. However, it is fairly clear from these results that polls and experts are not enough to predict elections</p>

                <p>I quote Nassim Taleb, author of ‘Black Swan’</p>

                <blockquote>
                    <div>
                        <p class="">What we are seeing worldwide, from India to the UK to the US, is the rebellion against the inner circle of no-skin-in-the-game policymaking “clerks” and journalists-insiders, that class of paternalistic semi-intellectual experts with some Ivy league, Oxford-Cambridge, or similar label-driven education who are telling the rest of us 1) what to do, 2) what to eat, 3) how to speak, 4) how to think… and 5) who to vote for.</p>

                        <p class="">With psychology papers replicating less than 40%, dietary advice reversing after 30y of fatphobia, macroeconomic analysis working worse than astrology, microeconomic papers wrong 40% of the time, the appointment of Bernanke who was less than clueless of the risks, and pharmaceutical trials replicating only 1/5th of the time, people are perfectly entitled to rely on their own ancestral instinct and listen to their grandmothers with a better track record than these policymaking goons.</p>
                        
                        <p class="">As an ‘expert’ who has been proven wrong (Brexit, Trump, Bihar), I have developed a healthy respect for the wisdom of the crowds.</p>
                    </div>
                </blockquote>
                
                <p>We are now taking this to another level</p>

                <p>We are creating India’s first predicting platform for Individuals to participate in and share their forecasts with the world. We roll out with the Gujarat election and would then expand it to other elections and categories. The method is simple, keep updating your forecasts until results day. Once results are announced, we compare your forecast with the actual result and classify the crowd into two groups</p>
                <ul>
                    <li>The Oracles</li>
                    <li>The Punters</li>
                </ul>
                <p>The Oracles are the ones who were closest to the result. The Punters are the ones who want to be Oracles. No one is a permanent Oracle and no one is a permanent Punter. That said, the more forecasts you get right, the longer you will remain an Oracle.</p>
                <p>We believe many of you will beat the so called experts and become Oracles. Our best wishes!</p>
                <p>Subhash Chandra</p>

                <p>Founder, The Campaign360 and <a href="https://Crowdwisdom.co.in" target="_blank">Crowdwisdom.co.in</a></p>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.banner').css('display', 'none');
        $('#aboutus').css('display', 'none');
    })
</script>