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
   <style>
      .paging {
      background: #fff;
      color: #ccc;
      margin-top: 1em;
      clear: both;
      font-family: Tahoma;
      font-size: 11px;
      }
      .paging .disabled {
      color: #ddd;
      }
      .paging .prev {
      border-left: 1px solid #ccc;
      -moz-border-radius: 4px 0 0 4px;
      -webkit-border-radius: 4px 0 0 4px;
      border-radius: 4px 0 0 4px;
      }
      .paging .current, .paging .disabled, .paging a {
      text-decoration: none;
      padding: 5px 8px;
      display: inline-block;
      }
      .paging > span {
      display: inline-block;
      border: 1px solid #ccc;
      border-left: 0;
      }
   </style>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="x-ua-compatible" content="ie=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>CSP Library</title>
      <!----<link rel="stylesheet" href="css/foundation.css">
      <link rel="stylesheet" href="css/app.css">---->
   </head>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.4/jquery.min.js"></script>
   <script>
      $(document).ready(function(){
        var delay = (function(){
        var timer = 0;
        return function(callback, ms){
          clearTimeout (timer);
          timer = setTimeout(callback, ms);
        };
      })();
      $('#qs_all').keyup(function() {
        
          delay(function(){
            document.frm1.submit();
          }, 1500 );
      });
      });
      /*$('#submit_search').click(function()
      {
        //alert('submit');
        var title=$('.title').val();
        var crop=$('.crop').val();
        var journal=$('.journal').val();
        var author=$('.author').val();
        var subcrop=$('.subcrop').val();
        if((title=='')&&(journal=='')&&(author=='')&&(subcrop =='')&&(crop==''))
        {
          alert('Search with any one field value');
          return false;
        }
        else
        {
          document.frm.method="POST";
          var str= window.location.href;  
          document.frm.action='/CSPLibrary/Users/genotype_search';      
          document.frm.submit();
        }
      });*/
      
      function submit_search()
      {
        //alert('submit_search');
        var title=$('.title').val();
        var crop=$('.crop').val();
        var journal=$('.journal').val();
        var author=$('.author').val();
        var subcrop=$('.subcrop').val();
        if((title=='')&&(journal=='')&&(author=='')&&(subcrop =='')&&(crop==''))
        {
          alert('Search with any one field value');
          return false;
        }
        else
        {
          document.frm.method="POST";
          var str= window.location.href;  
          document.frm.action='genotype_search';      
          document.frm.submit();
        }
      }
   </script>
   <body class="search">
      <div class="grid-container">
      <div class="grid-x">
         <div class="medium-3 cell callout logo-container">
            <!---<a href="/CSPLibrary/">
               <h1>CSPLAB Digital Library</h1>
            </a>---->
			<?php 
				echo $this->Html->link('<h1> CSP Labs Digital Library </h1>',
				array('controller' => 'Users', 'action' => 'home'),
				array('escape' => FALSE));
			?>
            <a id=smoothScroll class="scroll-to-top" href="#mainSearch"><img src="../assets/icon.up-arrow.png"></a>
         </div>
         <div class="medium-9 cell nav">
            <div class="grid-x">
               <div class="large-12 cell">
                  <div class="title-bar" data-responsive-toggle="responsive-menu" data-hide-for="large">
                     <button class="menu-icon" type="button" data-toggle="responsive-menu"></button>
                     <div class="title-bar-title">Menu</div>
                  </div>
                  <div class="top-bar" id="responsive-menu">
                     <div class="top-bar-left">
                        <ul class="dropdown menu" data-dropdown-menu>
                           <li>
                              <!--<a href="/CSPLibrary/users/molecular">Molecular Lab</a>
                              <ul class="menu">
                                 <li><a href="#">Item 1A</a></li>
                                 
                                 </ul>-->
								 <?php 
									echo $this->Html->link('Molecular Lab',
									array('controller' => 'Users', 'action' => 'molecular'));
								?>
                           </li>
                           <li>
                              <!--<a class="active" href="/CSPLibrary/users/genotype">Genotyping Lab</a>
                              <ul class="menu">
                                 <li><a href="#">Item 1A</a></li>
                                 
                                 </ul>-->
								 <?php 
									echo $this->Html->link('Genotyping Lab',
									array('controller' => 'Users', 'action' => 'genotype'),
									array('class' => 'active'));
								?>
                           </li>
                           <!-- <li><a href="#">Item 2</a></li>
                              <li><a href="#">Item 3</a></li>
                              <li><a href="#">Item 4</a></li>-->
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="grid-container">
         <div class="grid-x">
            <div class="large-3 cell">
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
                                       <label>Crop
                                       <input type="text" name="crop" id="crop" class="crop">
                                       </label>
                                    </div>
                                 </div>
                                 <div class="grid-x grid-padding-x">
                                    <div class="large-12 cell">
                                       <label>SubCrop
                                       <input type="text" name="subcrop" id="subcrop" class="subcrop">
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
            <div class="large-9 cell search-results">
               <div class="grid-x grid-padding-x grid-padding-y">
                  <div class="large-12 cell">
                     <form  id='frm1' name="frm1" action='genotype_search'>
                        <div id="mainSearch" class="input-group main-search">
                           <input class="input-group-field" id='qs_all' name='qs_all' placeholder="Keywords">
                           <input type="hidden" name="formval" id="formval" value='formval'/>
                           <div class="input-group-button">
                              <input type="submit" class="button large"  value="Search">
                           </div>
                        </div>
                     </form>
                     <!-- <p class="results">Results: <span id="results"> <?php echo count($rowvalue); ?></span> Found</p>-->
                  </div>
               </div>
                <!-- NEW PAGINATION BEGIN -->
               <div class="grid-x">
                  <nav aria-label="Pagination">
                     <ul class="pagination">
                        <li class="pagination-previous">
                           <?php
                              echo $this->Paginator->prev('' . __('Previous'), array(), null, array('class' => 'show-for-sr'));
                              ?>  
                           <span class="show-for-sr">page</span>
                        <li>
                           <!--<li class="current"><span class="show-for-sr">You're on page</span> 1</li>-->
                        <li><?php
                           echo $this->Paginator->numbers(array('separator' => '<li>'));    
                           ?>
                        </li>
                        <li class="pagination-next"><?php 
                           echo $this->Paginator->next(__('Next') . '', array(), null, array('class' => 'show-for-sr'));
                           ?>
                           <span class="show-for-sr">page</span></a>
                        </li>
                     </ul>
                  </nav>
               </div>
               <br />
               <div class="grid-x grid-padding-x">
                <div class="cell">
               
                 <span style='font-family: Tahoma;font-size:11px;'>
                 <?php
                    echo $this->Paginator->counter(
                            'Page {:page} of {:pages}, showing {:current} records out of
                     {:count} total, starting on record {:start}, ending on {:end}'
                    );
                    
                    $num_rec = $this->Paginator->params();
                    $num_rec = $num_rec['count'];
                    echo "<br>Total number of records ".$num_rec; 
                    
                    ?>
                 </span>
                </div>
              </div>
               <!-- NEW PAGINATION END -->
               <article>
                  <div class="grid-x grid-padding-x grid-padding-y">
                     <div class="large-12 cell">
                        <?php 
                           if($rowvalue!='')
                           { 
                             $i=0;
                             for($i=0;$i<count($rowvalue); $i++)
                             {
                               if(strlen($rowvalue[$i]['j']['Article_ID'])<3)
                               {           
                                 if(strlen($rowvalue[$i]['j']['Article_ID'])==1)
                                 { 
                                   $conc = '00'.$rowvalue[$i]['j']['Article_ID'];
                                 }
                                 else
                                   $conc = '0'.$rowvalue[$i]['j']['Article_ID'];
                               }
                               else
                                 
                                 $conc = $rowvalue[$i]['j']['Article_ID'];
                               
                               if($rowvalue[$i]['p']['In_use']=='')
                                 
                                 $checkbox = '';
                               else
                                 
                                 $checkbox = '<input type="checkbox" name="checkbox" style="margin: 5px 6px -6px -20px;cursor: auto;" disabled=true checked/>';
                               ?>
                        <?php 
                           if($rowvalue[$i]['j']['Title']!= $rowvalue[$i-1]['j']['Title'])
                           {
                             $rowvalue[$i]['j']['Title'] = preg_replace('/[\^£ÇT?~?|+¬]/', '', $rowvalue[$i]['j']['Title']);
                             ?>
                        <br><br>
                        <p class="article-title">
							<!--<a id="articleTitle" href="/CSPLibrary/users/geno_detail?id=<?php echo $rowvalue[$i]['j']['Article_ID'];?> " >
                           <?php echo $rowvalue[$i]['j']['Title'];?>
						   </a>-->
						   <?php echo $this->Html->link($rowvalue[$i]['j']['Title'],
								array('controller' => 'Users', 'action' => 'geno_detail?id='.$rowvalue[$i]['j']['Article_ID']),
								array('id'=>'articleTitle'));
							?>
                        </p>
						
                        <br>
                        <ul class="no-bullet">
                           <?php 
                              $rowvalue[$i]['j']['Journal'] = preg_replace('/[\^£ÇT?~?|+¬]/', '', $rowvalue[$i]['j']['Journal']);
                              $rowvalue[$i]['j']['Author'] = preg_replace('/[\^£ÇT?~?|+¬]/', '', $rowvalue[$i]['j']['Author']);
                              
                              ?>
                           <li id="authorName"><?php echo $rowvalue[$i]['j']['Author'];?></li>
                           <li id="journal"><?php echo $rowvalue[$i]['j']['Journal'];?></li>
                           <?php if($rowvalue[$i]['p']['Crop'] !='') { ?>
                           <li id="target"><?php echo $checkbox;?><?php echo $rowvalue[$i]['p']['Crop'];?>&nbsp;&nbsp;&nbsp;
                              <?php }
                                 if($rowvalue[$i]['p']['Subcrop'] !='') {
                                 ?>
                              <span id="acronym"> <?php echo $rowvalue[$i]['p']['Subcrop'];?></span>
                           </li>
                           <?php 
                              }
                              }
                              ?>
                           <?php
                              if($rowvalue[$i]['j']['Title']!= $rowvalue[$i-1]['j']['Title'])
                              {
                                foreach(glob('Genoarticles/'.$conc.'*') as $filename)
                                { 
                                  $file = explode('/', $filename);
                                ?>
                           <li><span ><a href="<?php echo $this->webroot;?><?php echo $filename;?>" id="supplementalFile"><?php echo $file[1];?></a></span></li>
                           <?php 
                              } 
                              }
                              ?>
                        </ul>
                        <?php         
                           }
                           //endforeach; 
                           }?>
                        <!-- <p class="article-title"><a id="articleTitle" href="detail">A CAPS marker TAO1-902 diagnostic for the I-2 gene conferring resistance to Fusarium oxysporum f. sp. Lycopersici race 2 in tomato</a><p>
                           <ul class="no-bullet">
                             <li id="authorName">M. Staniaszek, E. U. Kozik and W. Marczewski</li>
                             <li id="journal">Plant breeding doi: 10.111/j.143900523.2007.01355x</li>
                             <li id="target">Resistance to Fusarium oxysporum fsp lycopersici race 2 in tomato<span id="acronym">RS-Fol2</span></li>
                             <li><span class="label primary"><a href="#" id="supplementalFile">Article PDF</span></li>
                           </ul>-->
                     </div>
                  </div>
               </article>
            </div>
         </div>
      </div>
   </body>
</html>