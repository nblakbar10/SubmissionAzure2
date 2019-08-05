  <?php
require_once 'vendor/autoload.php';
require_once "./random_string.php";
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;
$connectionString = "DefaultEndpointsProtocol=https;AccountName=blobsubmission2;AccountKey=yw0I7Ct+dr7JTKLTlAyRygpIjDTmHF0o/Z/4a+W3Phr7aAwOEi+IMih3bJQQgrVevNev9leLU0paFofRLMqhvA==;EndpointSuffix=core.windows.net";
$containerName = "containersubmission2";
// Create blob client.
$blobClient = BlobRestProxy::createBlobService($connectionString);
if (isset($_POST['submit'])) {
	$fileToUpload = strtolower($_FILES["fileToUpload"]["name"]);
	$content = fopen($_FILES["fileToUpload"]["tmp_name"], "r");
	// echo fread($content, filesize($fileToUpload));
	$blobClient->createBlockBlob($containerName, $fileToUpload, $content);
	header("Location: analyze.php");
}
$listBlobsOptions = new ListBlobsOptions();
$listBlobsOptions->setPrefix("");
$result = $blobClient->listBlobs($containerName, $listBlobsOptions);
?>

<!DOCTYPE html>
<html>
 <head>
 <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">

	<title>Submission 2 Azure Computer Vision</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/starter-template/">

    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="starter-template.css" rel="stylesheet">

	
    <style>
	
		body {
            background: #FFFF99;
        }
        .navbar {
			padding-left: 170px;
            background-image: linear-gradient(to right, #1E9883, #FFFFFF);
        }
        .nav-link {
            color : white;
        }
        .starter-template {
            position: relative;
            z-index: 1;
        }
        h1 {
            font-family: 'Karla';
        }
        .lead {
            font-family: 'Karla';
        }
        main {
            z-index: 2;
            position: relative;
            margin-top: -59px;
            background-color: white;
			padding-top : 0!important;
            padding: 30px;
            border-radius: 9px;
        }
		.mt-4 {
			padding: 13px;
			box-shadow: -4px 5px 3px gainsboro;
            background-image: linear-gradient(to right, #999900, #FFFFCC);
			color: white;
		}
    </style>
  </head>
<body>

<script type="text/javascript">
    function processImage() {
        // **********************************************
        // *** Update or verify the following values. ***
        // **********************************************
 
        // Replace <Subscription Key> with your valid subscription key.
        var subscriptionKey = "1c88e6e2293b42f9964b2e8c45cd9f80";
 
        // You must use the same Azure region in your REST API method as you used to
        // get your subscription keys. For example, if you got your subscription keys
        // from the West US region, replace "westcentralus" in the URL
        // below with "westus".
        //
        // Free trial subscription keys are generated in the "westus" region.
        // If you use a free trial subscription key, you shouldn't need to change
        // this region.
        var uriBase =
            "https://southeastasia.api.cognitive.microsoft.com/vision/v2.0/analyze";
 
        // Request parameters.
        var params = {
            "visualFeatures": "Faces",
            "details": "",
            "language": "en",
        };
 
        // Display the image.
        var sourceImageUrl = document.getElementById("inputImage").value;
        document.querySelector("#sourceImage").src = sourceImageUrl;
 
        // Make the REST API call.
        $.ajax({
            url: uriBase + "?" + $.param(params),
 
            // Request headers.
            beforeSend: function(xhrObj){
                xhrObj.setRequestHeader("Content-Type","application/json");
                xhrObj.setRequestHeader(
                    "Ocp-Apim-Subscription-Key", subscriptionKey);
            },
 
            type: "POST",
 
            // Request body.
            data: '{"url": ' + '"' + sourceImageUrl + '"}',
        })
 
        .done(function(data) {
            // Show formatted JSON on webpage.
            $("#responseTextArea").val(JSON.stringify(data, null, 2));
        })
 
        .fail(function(jqXHR, textStatus, errorThrown) {
            // Display error message.
            var errorString = (errorThrown === "") ? "Error. " :
                errorThrown + " (" + jqXHR.status + "): ";
            errorString += (jqXHR.responseText === "") ? "" :
                jQuery.parseJSON(jqXHR.responseText).message;
            alert(errorString);
        });
    };
</script>

	<nav class="navbar navbar-expand-md fixed-top">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarsExampleDefault">
			<ul class="navbar-nav mr-auto">
			<li class="nav-item">
				<a class="nav-link" href="https://webappsubmission1.azurewebsites.net/">Home</a>
			</li>
			<li class="nav-item active">
				<a class="nav-link" href="https://webappsubmission1.azurewebsites.net/analisis.php">Analisis Gambar<span class="sr-only">(current)</span></a>
			</li>
		</div>
		</nav>

		<div class="starter-template"> <br><br><br>
        	<div class="container">
				<h1>Analisis gambar</h1>
					<p class="lead">Pilih gambar Yang ingin dianalisa.<br> Lalu klik <b>Upload</b>, untuk menganalisa gambar pilih <b>analisa</b> pada tabel.</p>
					<span class="border-top my-3"></span> <br> <br><br>
				</div>
		</div>

		<main role="main" class="container">
    		<br>
		<div class="mt-4 mb-2">
			<form class="" action="analyze.php" method="post" enctype="multipart/form-data">
				<input type="file" name="fileToUpload" accept=".jpeg,.jpg,.png" required="">
				<input type="submit" name="submit" value="Upload">
			</form>
		</div>

		<br>
		<br>
		<h4>Total Files : <?php echo sizeof($result->getBlobs())?></h4>
		<table class='table table-hover table-striped'>
			<thead>
				<tr>
					<th>File Name</th>
					<th>File URL</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				do {
					foreach ($result->getBlobs() as $blob)
					{
						?>
						<tr>
							<td><?php echo $blob->getName() ?></td>
							<td><?php echo $blob->getUrl() ?></td>
							<td>
								<form action="computervision.php" method="post">
									<input type="hidden" name="url" value="<?php echo $blob->getUrl()?>">
									<input type="submit" name="submit" value="Analisa!" class="btn btn-primary">
								</form>
							</td>
						</tr>

						<?php
					}
					$listBlobsOptions->setContinuationToken($result->getContinuationToken());
				} while($result->getContinuationToken());
				?>
			</tbody>
		</table>

	</div>


<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/popper.min.js"></script>
    <script src="https://getbootstrap.com/docs/4.0/dist/js/bootstrap.min.js"></script>
  </body>
</html>
