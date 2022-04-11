<!doctype html>
<?php
echo $this->Html->css("app.css");
echo $this->Html->css("foundation.css");
echo $this->Html->script('jquery');
echo $this->Html->script('app');
echo $this->Html->script('what-input');
echo $this->Html->script('foundation');

$this->Paginator->options(array('update' => '#content','evalScripts' => true));
?>
<html class="no-js" lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSP Library</title>
    <link rel="stylesheet" href="css/foundation.css">
    <link rel="stylesheet" href="css/app.css">
  </head
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>

$('#submit_search').click(function()
{
	alert('submit');
	var title=$('.title').val();
	var target=$('.target').val();
	var journal=$('.journal').val();
	var author=$('.author').val();
	var acronym=$('.acronym').val();
	if((title=='')&&(journal=='')&&(author=='')&&(acronym =='')&&(target==''))
	{
		alert('Search with any one field value');
		return false;
	}
	else
	{
		document.frm.method="POST";
		var str= window.location.href;	
		document.frm.action='/CSPLibrary/Users/molecular_search';		  
		document.frm.submit();
	}
});
var delay = (function(){
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();
$('#keyword_search').keyup(function() {
    delay(function(){
      document.frm.submit();
    }, 1500 );
});
function submit_search()
{
	alert('submit');
	var title=$('.title').val();
	var target=$('.target').val();
	var journal=$('.journal').val();
	var author=$('.author').val();
	var acronym=$('.acronym').val();
	if((title=='')&&(journal=='')&&(author=='')&&(acronym =='')&&(target==''))
	{
		alert('Search with any one field value');
		return false;
	}
	else
	{
		document.frm.method="POST";
		var str= window.location.href;	
		document.frm.action='/CSPLibrary/Users/molecular_search';		  
		document.frm.submit();
	}
}
</script>
  
  <body class="search">
    <div class="grid-container">
      <div class="grid-x" style='visibility: hidden'>
        <div class="large-3 cell callout logo-container">
          <h1>CSP Library</h1>
          <a id=smoothScroll class="scroll-to-top" href="#mainSearch"><img src="assets/icon.up-arrow.png"></a>
        </div>
		
        <div class="large-9 cell">
          <div class="grid-x">
            <div class="large-12 cell">
			<form  id='frm1' name="frm1" >
				<div id="mainSearch" class="input-group main-search">
					<input class="input-group-field" id='qs_all' name='qs_all' placeholder="Keywords">
					<input type="hidden" name="formval" id="formval" value='formval'/>
					<div class="input-group-button">
						<input type="submit" class="button large"  value="Search">
					</div>
			    </div>
			  </form>	
            </div>
          </div>
        </div>
	
      </div>
      <div class="grid-x">
        <div class="large-3 cell" style='visibility: hidden;width: 15%;'>
          <div class="refine-search">
            <ul class="accordion" data-accordion data-allow-all-closed="true" data-multi-expand="true">
              <li class="accordion-item" data-accordion-item>
                <!-- Accordion tab title -->
                <a href="#" class="accordion-title">Search By</a>

                <!-- Accordion tab content: it would start in the open state due to using the `is-active` state class. -->
                <div class="accordion-content" data-tab-content>
                 <form id='frm' name='frm'>
				 <input type="hidden" name="formval" id="formval" value='formval'/>
                    <div class="grid-container">
                      <div class="grid-x grid-padding-x">
                        <div class="large-12 cell">
                          <label>Title
                            <input type="text" name="title" id="title" class="title">
                          </label>
                        </div>
                      </div>
                      <div class="grid-x grid-padding-x">
                        <div class="large-12 cell">
                          <label>Author Name
                            <input type="text" name="qs_author" id="qs_author" class="qs_author">
                          </label>
                        </div>
                      </div>
                      <div class="grid-x grid-padding-x">
                        <div class="large-12 cell">
                          <label>Journal
                            <input type="text" id="journal" name="journal" class="journal">
                          </label>
                        </div>
                      </div>
                      <div class="grid-x grid-padding-x">
                        <div class="large-12 cell">
                          <label>Target
                            <input type="text" name="target" id="target" class="target">
                          </label>
                        </div>
                      </div>
                      <div class="grid-x grid-padding-x">
                        <div class="large-12 cell">
                          <label>Acronym
                            <input type="text" name="acronym" id="acronym" class="acronym">
                          </label>
                        </div>
                      </div>
                      <div class="grid-x grid-padding-x">
                        <div class="large-12 cell">
                          <a class="button expanded" id='submit_search' onclick='submit_search();' >Search</a>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </li>
            </ul>
          </div>
        </div>
        <div class="large-9 cell search-results" >
          <div class="grid-x grid-padding-x grid-padding-y" style='visibility: hidden'>
            <div class="large-12 cell">
              <p class="results">Results: <span id="results"></span> Found</p>
            </div>
          </div>
		  
		  <div>
          <article>
            <?php 
			//print_r($rowvalue);
			if($rowvalue !='')
			{
				//echo 'count = '.count($rowvalue);
				for($i=0;$i<count($rowvalue); $i++)
				{
					if(strlen($rowvalue[$i]['t']['Article_ID'])<3)
					{						
						if(strlen($rowvalue[$i]['t']['Article_ID'])==1)
						{	
							$conc = '00'.$rowvalue[$i]['t']['Article_ID'];
						}
						else
							$conc = '0'.$rowvalue[$i]['t']['Article_ID'];
					}
					else
						$conc = $rowvalue[$i]['t']['Article_ID'];
					if($rowvalue[$i]['p']['In_use']=='')
						$checkbox = '';
					else
						$checkbox = '<input type="checkbox" name="checkbox" style="margin: 5px 6px -6px -20px;" checked>';
				
				if($rowvalue[$i]['j']['Title'] != $rowvalue[$i-1]['j']['Title'])
				{
				?>
              <div class="large-10 cell">
			   <p class="article-title"><a id="articleTitle" ><?php echo $rowvalue[$i]['j']['Title'] ?></a><p>
                <ul class="no-bullet">
                  <li id="authorName"><?php echo $rowvalue[$i]['j']['Author'];?></li>
                  <li id="journal"><?php echo $rowvalue[$i]['j']['Journal'];?></li>
                  <?php if($rowvalue[$i]['t']['Target_name'] !=''){ ?>
                  <li id="target"><?php echo $checkbox;?><?php echo $rowvalue[$i]['t']['Target_name'];?>
                  <?php }
                  if($rowvalue[$i]['t']['Acronym'] !=''){ ?>
                  <span id="acronym"><?php echo $rowvalue[$i]['t']['Acronym'];?></span></li>
                  <?php } ?>
                 <!-- <li><span class="label primary"><a href="<?php echo $this->webroot;?><?php echo $filename;?>" id="supplementalFile"><?php echo $file[1];?></span></li>-->
                </ul>
              </div>
			<?php 
				
				
			?>
          </article>
		  <br><br>
		  <div >
		  <?php
		  foreach(glob('Articles/'.$conc.'*') as $filename)
			{ 
				$file = explode('/', $filename);
				//echo $filename;
				?>
		<iframe id="iframe" src ="<?php echo $this->webroot; ?><?php echo $filename;?>" frameborder="0" style="overflow:hidden;height:550px;width:100% " height="100%" width="100%"   ></iframe>
		</div>
		<?php 
			}
		}	
		}
		}
		?>
		  </div>
		
          
        </div>
      </div>
    </div>

  </body>
</html>
