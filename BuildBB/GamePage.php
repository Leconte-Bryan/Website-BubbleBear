<?php
include("../init.php");
/*
if (isset($_SESSION["username"])) {
  echo 'username : ' . $_SESSION["username"];
} else {
  echo "no username found" . "<br>";
}*/
?>
<!DOCTYPE html>
<html lang="en-us">

<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Unity Web Player | Bubbles GGJ</title>
  <link rel="shortcut icon" href="TemplateData/favicon.ico">
  <link rel="stylesheet" href="TemplateData/style.css">
      <style>canvas {
  /* ==== Disable the Android/iOS/Chrome tap highlight ==== */
  -webkit-tap-highlight-color: transparent;

  /* ==== Disable text/element selection ==== */
  -webkit-user-select: none;  /* Chrome/Safari */
  -moz-user-select: none;     /* Firefox */
  -ms-user-select: none;      /* IE/Edge */
  user-select: none;          /* Standard */

  /* ==== (Optional) Disable default touch-move behavior ==== */
  /* touch-action: none; */
}</style>
</head>

<body style="background: rgb(52, 47, 47);">
  <div id="unity-container" class="unity-desktop">
    <canvas id="unity-canvas" width=960 height=600 tabindex="-1"></canvas>
    <div id="unity-loading-bar">
      <div id="unity-logo"></div>
      <div id="unity-progress-bar-empty">
        <div id="unity-progress-bar-full"></div>
      </div>
    </div>
    <div id="unity-warning"> </div>
    <div id="unity-footer">
      <div id="unity-logo-title-footer"></div>
      <div id="unity-fullscreen-button"></div>
      <div id="unity-build-title">Bubbles GGJ</div>
    </div>
  </div>
  <script>
    var canvas = document.querySelector("#unity-canvas");

    // Shows a temporary message banner/ribbon for a few seconds, or
    // a permanent error message on top of the canvas if type=='error'.
    // If type=='warning', a yellow highlight color is used.
    // Modify or remove this function to customize the visually presented
    // way that non-critical warnings and error messages are presented to the
    // user.
    function unityShowBanner(msg, type) {
      var warningBanner = document.querySelector("#unity-warning");

      function updateBannerVisibility() {
        warningBanner.style.display = warningBanner.children.length ? 'block' : 'none';
      }
      var div = document.createElement('div');
      div.innerHTML = msg;
      warningBanner.appendChild(div);
      if (type == 'error') div.style = 'background: red; padding: 10px;';
      else {
        if (type == 'warning') div.style = 'background: yellow; padding: 10px;';
        setTimeout(function() {
          warningBanner.removeChild(div);
          updateBannerVisibility();
        }, 5000);
      }
      updateBannerVisibility();
    }

    var buildUrl = "Build";
    var loaderUrl = buildUrl + "/BBuble.loader.js";
    var config = {
      arguments: [],
      dataUrl: buildUrl + "/BBuble.data.unityweb",
      frameworkUrl: buildUrl + "/BBuble.framework.js.unityweb",
      codeUrl: buildUrl + "/BBuble.wasm.unityweb",
      streamingAssetsUrl: "StreamingAssets",
      companyName: "DefaultCompany",
      productName: "Bubbles GGJ",
      productVersion: "1.0",
      showBanner: unityShowBanner,
    };

    // By default, Unity keeps WebGL canvas render target size matched with
    // the DOM size of the canvas element (scaled by window.devicePixelRatio)
    // Set this to false if you want to decouple this synchronization from
    // happening inside the engine, and you would instead like to size up
    // the canvas DOM size and WebGL render target sizes yourself.
    // config.matchWebGLToCanvasSize = false;

    // If you would like all file writes inside Unity Application.persistentDataPath
    // directory to automatically persist so that the contents are remembered when
    // the user revisits the site the next time, uncomment the following line:
    // config.autoSyncPersistentDataPath = true;
    // This autosyncing is currently not the default behavior to avoid regressing
    // existing user projects that might rely on the earlier manual
    // JS_FileSystem_Sync() behavior, but in future Unity version, this will be
    // expected to change.

    if (/iPhone|iPad|iPod|Android/i.test(navigator.userAgent)) {
      // Mobile device style: fill the whole browser client area with the game canvas:

      var meta = document.createElement('meta');
      meta.name = 'viewport';
      meta.content = 'width=device-width, height=device-height, initial-scale=1.0, user-scalable=no, shrink-to-fit=yes';
      document.getElementsByTagName('head')[0].appendChild(meta);
      document.querySelector("#unity-container").className = "unity-mobile";
      canvas.className = "unity-mobile";

      // To lower canvas resolution on mobile devices to gain some
      // performance, uncomment the following line:
      // config.devicePixelRatio = 1;


    } else {
      // Desktop style: Render the game canvas in a window that can be maximized to fullscreen:
      canvas.style.width = "960px";
      canvas.style.height = "600px";
    }

    document.querySelector("#unity-loading-bar").style.display = "block";

    var script = document.createElement("script");
    script.src = loaderUrl;
    script.onload = () => {

      createUnityInstance(canvas, config, (progress) => {
        document.querySelector("#unity-progress-bar-full").style.width = 100 * progress + "%";
      }).then((unityInstance) => {
        // Make unity instance global
        // For debugging purpose
        window.unityInstance = unityInstance;


        // Get the username of the current Session
        // json_encode make sure to transform it from a javascript variable to a string one (in this case)

        var playerUsername = <?php echo json_encode($_SESSION["username"] ?? null); ?>;
        let username = <?php echo json_encode($_SESSION["username"] ?? null); ?>;
        console.log("Username is:", username);

        if (typeof username  != "undefined" && username !== null) {
          // Use the method from unity to add the username to the menu UI
          unityInstance.SendMessage('MenuManager', 'DisplaySessionID', playerUsername);
          console.log("User is logged in as", username);
        } else {
          // Use the method from unity to add the username to the menu UI
          unityInstance.SendMessage('MenuManager', 'DisplaySessionID', "Visitor");
          console.log("No user logged in");
        }







        document.querySelector("#unity-loading-bar").style.display = "none";
        document.querySelector("#unity-fullscreen-button").onclick = () => {
          unityInstance.SetFullscreen(1);
        };

      }).catch((message) => {
        alert(message);
      });
    };
    document.body.appendChild(script);
  </script>
</body>
<!--
<button style="border: 50px black; height: 80px; text-align:left;" onclick="unityInstance.SendMessage('MenuManager', 
        'DisplaySessionID', 'test from website')">test display on unity</button>
</body>
  -->
</html>