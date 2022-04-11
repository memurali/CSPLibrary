<?php
App::build(array('Vendor' => array(APP . 'Vendor' . DS . 'stripe-php' . DS)));
class UsersController extends AppController
{   
    var $helpers = array('Html', 'Form', 'Csv', 'Js', 'Paginator');    
    public $uses = array('contact', 'TitleLevel', 'Emailmarketer', 'Plandetail');   
    public $components = array('Paginator', 'RequestHandler', 'Stripe');
    
    public function beforeFilter()
    {
        parent::beforeFilter();
        $role = $this->Auth->user('role');
        $this->set('role', $role);
        $this->Auth->allow('index','home','detail','geno_detail','molecular','molecular_search','genotype','genotype_search');
    }
	function home()
	{
		
	}
	function genotype()
	{
		$this->loadModel('Tblgenotype_author_journal');
		$this->loadModel('Tblgenotype_primer');
		$url = $this->here;
		$pageno=split(':',$url);
		
		$formval= $this->params['url']['formval'];
		$all= $this->params['url']['qs_all'];
		$crop = $this->params['url']['crop'];
		$author = $this->params['url']['qs_author'];
		$journal = $this->params['url']['journal'];
		$subcrop = $this->params['url']['subcrop'];
		$title = $this->params['url']['title'];		
		if($pageno[1] !='')	
			$limit_start=($pageno[1]-1).'1';
		else
			$limit_start=0;
		
		
		/*if($all!='')
		{
			$condition = "CONCAT(p.Crop,p.Subcrop,j.Journal,j.Title,j.Author) LIKE '%".$all."%' ";
		}
		else
		{
			$condition = " p.Crop like '%".$crop."%' and j.Author like '%".$author."%' and
						j.Journal like '%".$journal."%' and p.Subcrop like '%".$subcrop."%' and
						j.Title like '%".$title."%' ";
		}
		if($formval!='')
		{
			
			$select ="SELECT j.Article_ID, j.Author, j.Title, j.Journal, p.Crop, 
					p.Subcrop, p.In_use FROM 
					Tblgenotype_author_journal j 
					left OUTER join tblgenotype_primer p ON j.Article_ID = p.Article_ID where ".$condition." 
					group by j.Title order by j.Title asc";
		}
		else
		{*/
			
			$select ="SELECT j.Article_ID,  j.Author, j.Title, j.Journal, p.Crop, 
				  p.Subcrop, p.In_use FROM 
				  tblgenotype_author_journal j 
				  left OUTER join tblgenotype_primer p ON j.Article_ID = p.Article_ID 
				  GROUP by j.Title order by j.Title asc LIMIT $limit_start,20";
				  $data = $this->paginate('Tblgenotype_author_journal');
		//}
		
		$select = $this->Tblgenotype_author_journal->query($select);
		$this->set('rowvalue', $select);
		$this->set('all', $all);
		$this->set('crop', $crop);
		$this->set('author', $author);
		$this->set('journal', $journal);
		$this->set('subcrop', $subcrop);
		$this->set('title', $title);
		
	}
	
	function geno_detail()
	{
		$articleid = $this->params['url']['id'];
		//echo $articleid;
		$this->loadModel('Tblgenotype_author_journal');
		$select='SELECT j.Article_ID,  j.Author, j.Title, j.Journal, p.Crop, 
				  p.Subcrop, p.In_use FROM 
				  tblgenotype_author_journal j 
				  left OUTER join tblgenotype_primer p ON j.Article_ID ='.$articleid.' where j.Article_ID=p.Article_ID ';    //'.$articleid;
				//echo $select;
		$select = $this->Tblgenotype_author_journal->query($select);
		$this->set('rowvalue', $select);	
	}
	function detail()
	{
		$articleid = $this->params['url']['id'];
		
		$this->loadModel('Tblmolecular_author_journal');
		$select='SELECT t.Article_ID,t.Target_name, t.Acronym, 
				j.Author, j.Title, j.Journal, p.Primer_R, p.Primer_F, 
				p.In_use FROM tblmolecular_author_journal j left OUTER join 
				tblmolecular_primer p ON j.Article_ID = p.Article_ID 
				INNER JOIN tblmolecular_target t ON j.Article_ID ='.$articleid.' where j.Article_ID=t.Article_ID' ;
				//echo $select;
		$select = $this->Tblmolecular_author_journal->query($select);				  
		$this->set('rowvalue', $select);		
	}
	
	function genotype_search()
	{
		set_time_limit(0);
		ini_set('memory_limit', '-1');
		$this->loadModel('Tblgenotype_author_journal');
		$this->loadModel('Tblgenotype_primer');
		if($this->request->data['variable']=='filter')
			$all = $this->request->data['qs_all'];
		else
			$all= $this->params['url']['qs_all'];	
		$crop = $this->request->data['crop'];
		$author = $this->request->data['qs_author'];
		$journal = $this->request->data['journal'];
		$subcrop = $this->request->data['subcrop'];
		$title = $this->request->data['title'];
		$select ="SELECT j.Article_ID, j.Author, j.Title, j.Journal, p.Crop, 
				  p.Subcrop, p.In_use FROM 
				  tblgenotype_author_journal j 
				  left OUTER join tblgenotype_primer p ON j.Article_ID = p.Article_ID where ";
				  
		if($all!='')
		{
			$condition = "CONCAT(p.Crop,p.Subcrop,j.Journal,j.Title,j.Author) LIKE '%".$all."%' ";
		}
		else
		{
			$condition = " p.Crop like '%".$crop."%' and j.Author like '%".$author."%' and
						j.Journal like '%".$journal."%' and p.Subcrop like '%".$subcrop."%' and
						j.Title like '%".$title."%' ";
		}		  
				  
				  
			$group = "group by j.Title order by j.Title asc";
		
				
		/****Search flow***/
		if($this->request->data['formval']!='' || $this->params['url']['formval']!='') {
			$this->set('all', $all);
			$this->set('crop', $crop);
			$this->set('author', $author);
			$this->set('journal', $journal);
			$this->set('subcrop', $subcrop);
			$this->set('title', $title);
			$select= $select.$condition.$group;
						
			/****Getting distinct Crop for filter***/
			$distinct ="SELECT DISTINCT p.Crop FROM 
				  tblgenotype_author_journal j 
				  left OUTER join tblgenotype_primer p ON j.Article_ID = p.Article_ID where ";
						
			$group1 = "group by j.Title order by trim(p.Crop) asc";
			$select1= $distinct.$condition.$group1;
			
			/***Assigning values***/
			$select = $this->Tblgenotype_author_journal->query($select);
			$this->set('rowvalue', $select);
			
			//echo 'formval = '.$this->request->data['formval'];
			//echo '<br>select1 = '.$select1;
			$select1 = $this->Tblgenotype_author_journal->query($select1);
			$this->set('filterval', $select1);
		}
		
		/**** Filter process****/
		if($this->request->is('ajax')){
			
			$cropval = trim (trim($this->request->data['crop'], "|"));
			$cropval = explode("|",$cropval);
			
			/**For 'Filter By' div values ***/
			$checkval = implode(",",$cropval);
			$this->set('crops',$checkval);
					
			$cropval = trim (implode("','",$cropval));
			if($all!='')
			{
				$condition = "CONCAT(p.Subcrop,j.Journal,j.Title,j.Author) LIKE '%".$all."%' and";
			}
			else
			{
				$condition = "j.Author like '%".$author."%' and
						j.Journal like '%".$journal."%' and p.Subcrop like '%".$subcrop."%' and
						j.Title like '%".$title."%' and ";
			}
			$filter_crop = " p.Crop IN ('".$cropval."') ";
			$select = $select.$condition.$filter_crop.$group;
			$select = $this->Tblgenotype_author_journal->query($select);    
			$this->set('rowvalue', $select);
			$this->render('filter');
		
		}
		
		
	}
	
	
	function molecular_search()
	{
		set_time_limit(0);
		ini_set('memory_limit', '-1');
		$this->loadModel('Tblmolecular_author_journal');
		$this->loadModel('Tblmolecular_primer');
		$this->loadModel('Tblmolecular_target');
		if($this->request->data['variable']=='filter')
			$all = $this->request->data['qs_all'];
		else
			$all= $this->params['url']['qs_all'];	
		$target = $this->request->data['target'];
		$author = $this->request->data['qs_author'];
		$journal = $this->request->data['journal'];
		$acronym = $this->request->data['acronym'];
		$title = $this->request->data['title'];
		//echo 'title = '.$title;
		$select ="SELECT t.Article_ID,t.Target_name, t.Acronym, 
				j.Author,j.Article_ID,j.Title, j.Journal, p.Primer_R, p.Primer_F, 
				p.In_use FROM tblmolecular_author_journal j left OUTER join 
				tblmolecular_primer p ON j.Article_ID = p.Article_ID 
				INNER JOIN tblmolecular_target t ON j.Article_ID = t.Article_ID where ";
				  
		if($all!='')
		{
			$condition = "CONCAT(t.Target_name,t.Acronym,j.Journal,j.Title,j.Author) LIKE '%".$all."%' ";
		}
		else
		{
			$condition = " t.Target_name like '%".$target."%' and j.Author like '%".$author."%' and
						j.Journal like '%".$journal."%' and t.Acronym like '%".$acronym."%' and
						j.Title like '%".$title."%' ";
		}		  
				  
			//echo $condition;  
			$group = "group by t.Target_name order by j.Title asc";
		
			
			//echo $this->request->data['formval'];
		/****Search flow***/
		if($this->request->data['formval']!='' || $this->params['url']['formval'] !='') {
			$this->set('all', $all);
			$this->set('target', $target);
			$this->set('author', $author);
			$this->set('journal', $journal);
			$this->set('acronym', $acronym);
			$this->set('title', $title);
			$select= $select.$condition.$group;
					
			/****Getting distinct Target for filter***/
			$distinct ="SELECT DISTINCT t.Target_name FROM tblmolecular_author_journal j 
						left OUTER join tblmolecular_primer p ON 
						j.Article_ID = p.Article_ID 
						INNER JOIN tblmolecular_target t ON 
						j.Article_ID = t.Article_ID where ";
						
			$group1 = "group by j.Title order by trim(t.Target_name) asc";
			$select1= $distinct.$condition.$group1;
		
			
			/***Assigning values***/
			$select = $this->Tblmolecular_author_journal->query($select);
			$this->set('rowvalue', $select);
			
				
			
			$select1 = $this->Tblmolecular_author_journal->query($select1);
			$this->set('filterval', $select1);
		}
		
		/**** Filter process****/
		if($this->request->is('ajax')){
			
			$targetval = trim (trim($this->request->data['target'], "|"));
			$targetval = explode("|",$targetval);
			
			/**For 'Filter By' div values ***/
			$checkval = implode(",",$targetval);
			$this->set('targets',$checkval);
					
			$targetval = trim (implode("','",$targetval));
			if($all!='')
			{
				$condition = "CONCAT(t.Acronym,j.Journal,j.Title,j.Author) LIKE '%".$all."%' and";
			}
			else
			{
				$condition = "j.Author like '%".$author."%' and
						j.Journal like '%".$journal."%' and t.Acronym like '%".$acronym."%' and
						j.Title like '%".$title."%' and ";
			}
			$filter_target = " t.Target_name IN ('".$targetval."') ";
			$select = $select.$condition.$filter_target.$group;
			$select = $this->Tblmolecular_author_journal->query($select);    
			$this->set('rowvalue', $select);
			$this->render('filter_molecular');			
		}
		
	}
	function molecular()
	{
		$this->loadModel('Tblmolecular_author_journal');
		$this->loadModel('Tblmolecular_primer');
		$this->loadModel('Tblmolecular_target');
		$url = $this->here;
		$pageno=split(':',$url);
		$formval= $this->params['url']['formval'];
		$all= $this->params['url']['qs_all'];
		$target = $this->params['url']['target'];
		$author = $this->params['url']['qs_author'];
		$journal = $this->params['url']['journal'];
		$acronym = $this->params['url']['acronym'];
		$title = $this->params['url']['title'];		
		if($pageno[1] !='')	
			$limit_start=($pageno[1]-1).'1';
		else
			$limit_start=0;
		
		/*if($all!='')
		{
			$condition = "CONCAT(t.Target_name,t.Acronym,j.Journal,j.Title,j.Author) LIKE '%".$all."%' ";
		}
		else
		{
			$condition = " t.Target_name like '%".$target."%' and j.Author like '%".$author."%' and
						j.Journal like '%".$journal."%' and t.Acronym like '%".$acronym."%' and
						j.Title like '%".$title."%' ";
		}		  
				  
		if($formval!='')
		{			
			$select ="SELECT t.Article_ID,t.Target_name, t.Acronym, 
				j.Author,j.Article_ID, j.Title, j.Journal, p.Primer_R, p.Primer_F, 
				p.In_use FROM tblmolecular_author_journal j left OUTER join 
				tblmolecular_primer p ON j.Article_ID = p.Article_ID 
				INNER JOIN Tblmolecular_target t ON j.Article_ID = t.Article_ID  where ".$condition."
				group by t.Target_name order by j.Title ";
				
		}
		else
		{*/
			$select ="SELECT t.Article_ID,t.Target_name, t.Acronym, 
				j.Author, j.Title,j.Article_ID, j.Journal, p.Primer_R, p.Primer_F, 
				p.In_use FROM tblmolecular_author_journal j left OUTER join 
				tblmolecular_primer p ON j.Article_ID = p.Article_ID 
				INNER JOIN tblmolecular_target t ON j.Article_ID = t.Article_ID 
				group by t.Target_name order by j.Title asc LIMIT $limit_start,10";
				$data = $this->paginate('Tblmolecular_author_journal');
				
		//}
		//echo $select;
		$select = $this->Tblmolecular_author_journal->query($select);				  
		$this->set('rowvalue', $select);
		$this->set('all', $all);
		$this->set('target', $target);
		$this->set('author', $author);
		$this->set('journal', $journal);
		$this->set('acronym', $acronym);
		$this->set('title', $title);
		
		
	}
	function filter()
	{
		
	}	
    
}



?>

