<!doctype html>
<html><!-- InstanceBegin template="/Templates/Template.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="UTF-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>SimpleStore</title>
<!-- InstanceEndEditable -->

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<!--[if IE]>
	<script>
		document.createElement('header');
		document.createElement('nav');
		document.createElement('section');
		document.createElement('article');
		document.createElement('aside');
		document.createElement('footer');
	</script>
 <![endif]-->

<script type="text/javascript">
    function subMenuVisible()
    {
	    var obj = document.getElementById('subMenu');
	    obj.style.visibility='visible';
	    obj.style.display='block';
    }
    function subMenuHidden()
    {
	    var obj = document.getElementById('subMenu');
	    obj.style.visibility='hidden';
	    obj.style.display='none';
    }
</script>

<!-- BEGIN JIVOSITE CODE {literal} -->
<script type="text/javascript">
(function() { var widget_id = '22410';
var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss); })(); </script> 
<!-- {/literal} END JIVOSITE CODE -->

<script type="text/javascript" src="/Templates/JavaScripts.js"></script>
<link href="/Templates/Style.css" rel="stylesheet" type="text/css">

</head>
<body>

<div class="container">

	<header>
    <table class="header_top" cellpadding="0" cellspacing="0">
    <tr>
    <td>
    	<div class="companyName">
        <span>
		    <?php 
			    if ($_SESSION['connected']) 
				    echo "<a href='/'>".$_SESSION['company']."</a>";
				else
				    echo "<a href='/'>SimpleStore</a>";
			?>
		</span>
        <!-- end .companyName --></div>
     </td>
     <td class="header_info">
     	<div class="log-reg">
         <?php if(!$_SESSION['connected']) {?>
             <a href="/Connection"> Вход </a>
             <a href="/Registration"> Регистрация </a>
         <?php } else {?>
         	 <span> Вы вошли, как <?php echo $_SESSION['rank']; ?><span>
             <a href="/Logout"> Выход </a>
         <?php }?>
     	</div>
    </tr>
	</table>

        <nav class="menu">
            <?php require_once $view['Menu'];?>
        </nav>
  	<!-- end .header --></header>

<!-- InstanceBeginEditable name="content" -->
 	<section>
        <?php require_once $view['Content'];?>
 	</section>
<!-- InstanceEndEditable -->
  
  
	<footer>
    <span>SimpleStore © 2012 </span>
 	<!-- end .footer --></footer>
  
<!-- end .container --></div>

</body>
<!-- InstanceEnd --></html>
