

<!DOCTYPE html>
<html>
<head>
<title>Facebook Login JavaScript Example</title>
<meta charset="UTF-8">
</head>
<body>
<script>
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
      console.log('statusChangeCallback');
      console.log(response);
      // The response object is returned with a status field that lets the
      // app know the current login status of the person.
      // Full docs on the response object can be found in the documentation
      // for FB.getLoginStatus().
      
      if (response.status === 'connected') {
        // Logged into your app and Facebook.
        testAPI();
      } else {
        // The person is not logged into your app or we are unable to tell.
        document.getElementById('status').innerHTML = 'Please log ' +'into this app.';
      }

  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

//https://developers.facebook.com/tools/explorer/

  //EAACEdEose0cBAKxuoQjG4Wui9TlE3n2DX0ySa5TrHHbSLayzHSMFvYUs9z4l37ThLddepSTv7ZAZACxf9znAL6CJ79P7l8og7CAkVKTESRnuXdtE0I0LwFlmoZC25PUjDUNx1xL2kzZAuLv3K6GIj3skIg8dXuIOFLLFXTrLTo3qBQruSc9A7W5cjZAXz26YZD

  clave secreta de la app:21624e43c0f9f9833019a33e914347a2
  appid 1891772734431460

https://graph.facebook.com/v2.8/oauth/access_token?grant_type=fb_exchange_token&client_id=1815377358727491&client_secret=21624e43c0f9f9833019a33e914347a2&fb_exchange_token=EAACEdEose0cBAMZBfjRV4EMyZBTXbr2a0GsUyrtzBRDSdLdmkMRZBdg7CuCpY5AkkZAMIOI3rq1o9gzjcZCoMFbkLrqvTJrFpWcuiRYCkqENUiCpUerJsXxvCCYD5LhvqGnZCjndQcEUHuolfGzzeeTBfcJbgizZBRZCr61CkEETjln2jmZBrTsWKGBgYo5MUMsQZD

/*
  https://graph.facebook.com/v2.0/oauth/access_token?grant_type=fb_exchange_token&client_id=1891772734431460&client_secret=21624e43c0f9f9833019a33e914347a2&fb_exchange_token=EAACEdEose0cBAMZBfjRV4EMyZBTXbr2a0GsUyrtzBRDSdLdmkMRZBdg7CuCpY5AkkZAMIOI3rq1o9gzjcZCoMFbkLrqvTJrFpWcuiRYCkqENUiCpUerJsXxvCCYD5LhvqGnZCjndQcEUHuolfGzzeeTBfcJbgizZBRZCr61CkEETjln2jmZBrTsWKGBgYo5MUMsQZD
*/
  {
  "id": "1815377358727491",
  "name": "Osmel Calderon Bernal"
}


FB.api(
  '/me',
  'GET',
  {"fields":"id,name"},
  function(response) {
      // Insert your code here
  }
);

=== Query
  curl -i -X GET \
   "https://graph.facebook.com/v2.8/me?fields=id%2Cname&access_token=<access token sanitized>"
=== Access Token Info
  {
    "perms": [
      "publish_actions",
      "public_profile"
    ],
    "user_id": 1815377358727491,
    "app_id": 145634995501895
  }
=== Parameters
- Query Parameters

  {
    "fields": "id,name"
  }
- POST Parameters

  {}
=== Response
  {
    "id": "1815377358727491",
    "name": "Osmel Calderon Bernal",
    "__debug__": {}
  }
=== Debug Information from Graph API Explorer
- https://developers.facebook.com/tools/explorer/?method=GET&path=me%3Ffields%3Did%2Cname&version=v2.8




  window.fbAsyncInit = function() {
  FB.init({
    appId      : '225197927866923',
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.8' // use graph api version 2.8
  });

  // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });

  };

  // Load the SDK asynchronously
  /*
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

*/


    (function(d, s, id){
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) {
        
        return;
      }
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/es_LA/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);

    }(document, 'script', 'facebook-jssdk'));  


  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
      console.log('Welcome!  Fetching your information.... ');
      FB.api('/me', function(response) {
        console.log('Successful login for: ' + response.name);
        document.getElementById('status').innerHTML =
          'Thanks for logging in, ' + response.name + '!';
      });
  }



</script>

<!--


//http://yises.com/blog/2015/06/25/problema-con-el-localstorage-y-modo-incognito-en-safari/
//https://fernetjs.com/2012/12/almacenando-en-el-cliente-localstorage-sessionstorage-y-cookies/

//if (window.localStorage) 
//https://developers.facebook.com/docs/facebook-login/web
//https://developers.facebook.com/docs/javascript/advanced-setup
//https://www.facebook.com/sharer/sharer.php?u=http://67.205.182.175/


  Below we include the Login Button social plugin. This button uses
  the JavaScript SDK to present a graphical Login button that triggers
  the FB.login() function when clicked.
-->

<fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
</fb:login-button>

<div id="status">
</div>

</body>
</html>