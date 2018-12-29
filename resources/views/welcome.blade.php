<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>ZCash</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    </head>
    <body>
      <form class="convert">
        <input id="myFile" type="file"/>
        <textarea id="myTextArea" rows="4" columns="20"></textArea>
        <input type="submit" value="submit"/>
      </form>
      <div id="displayTree">
      </div>
    </body>
    <script>
    $(document).ready(function () {
    var childLevel = 0;
    var resultTree=[];
    function insertChildren(traverseArr) {

			childLevel++;
			var currentKeys =Object.keys(traverseArr);
			if(currentKeys.length>0)
			{
				for(let i = 0; i < currentKeys.length; i++) {
					var object=traverseArr[currentKeys[i]];

					var node={
						value:currentKeys[i],
						level:childLevel
					}
					resultTree.push(node);
					//console.log(currentKeys[i],childLevel);
					insertChildren(object)
					childLevel--;
				}
			}
      if(traverseArr && traverseArr.length > 0) {
				for(let i = 0; i < traverseArr.length; i++) {
                insertChildren(traverseArr[i])
				}
      }
    }
    function displayTree(item) {
      var dashs="";
      for(var i=0;i<item.level;i++)
      {
        dashs+="-";
      }

      $("#displayTree").append("<p>"+dashs+item.value+"</p>");

    }
      $(".convert").submit(function(e){
            e.preventDefault();
    		var textArea = document.getElementById("myTextArea");

        var post_data=JSON.parse(textArea.value);

        $.post("http://127.0.0.1:8000/api/",
                post_data
                , function (data, status) {
                    if (!data.error) {
                      resultTree=[];
                      childLevel = 0;
                      insertChildren(data,resultTree);
                      resultTree.forEach(displayTree);
                    	console.log(resultTree);
                    } else
                        alert("error");
                });


          });
        document.getElementById('myFile').onchange = function() {
            var file = document.getElementById("myFile").files[0];
        	var reader = new FileReader();
        	reader.onload = function (e) {
        		var textArea = document.getElementById("myTextArea");
        		textArea.value = e.target.result;
        	};
        	reader.readAsText(file);
        };
    });
    </script>
  </html>
