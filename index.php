
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>
<body style="background-color:rgb(196,166,166);">
<br>
    <div style="
    margin: 0 auto;      /*centrer l'element*/
    max-width: 1000px;   /*largeur max de l'element 1000px*/
}">
   <h1>Utilisateurs</h1>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">#id</th>
        <th scope="col">Nom</th>
        <!--<th scope="col">Prenom</th>-->
        <th scope="col">Facture</th>
      </tr>
    </thead>
    <tbody><?php
                                            //DB CONNECTION
            $con = new PDO('mysql:host=localhost;dbname=bddfpdf;charset=utf8','root', '');
          // $con = new PDO('mysql:host=veckod.com;dbname=veckuwya_bddfpdf;charset=utf8','veckuwya_vick', 'AzErTyY20v');
            $query = "SELECT * FROM utilisateur";
            $query2 = "SELECT * FROM utilisateur";
            $result = $con->prepare($query);
            $result2 = $con->prepare($query);
            $result->execute();
            $result2->execute();
            if($result->rowCount()||$result2->rowCount()){
                while($utilisateur = $result->fetch()){
                    ?>
                    
                    <tr>
                    <th scope="row"><?php echo $utilisateur['id']; ?></th>
                    <td><?php echo $utilisateur['nom']; ?></td>
                  <!--  <td><?php// echo $utilisateur['prenom']; ?></td>-->
                  <!--<td><a href="factures.php?uid=<?php// echo $utilisateur['id']?>&numF=<?php //echo $facture['num_facture']; ?>" type="button" class="btn btn-danger">PDF </a></td>-->
                    <td><a href="factures.php?uid=<?php echo $utilisateur['id'];?>" type="button" class="btn btn-danger">PDF </a></td>
                    
                    </tr>         
                    <?php
                    
                }

                ?>
    </tbody>
  </table>
  <div>
    <h1>Rediger un lettre:</h1>
    <br>
    <form action="lettre.php" method="POST">
       
      <select class="form-select" aria-label="Default select example" name="nomUser">
       
        <?php while($utilisateur = $result2->fetch()){?>
         <option ><?php echo $utilisateur['nom']?></option>;         
         <br><?php 
        }?>
      </select>
      <br>
      <textarea type="text" cols="130" rows="6" maxlength="950" id="textarea" name="textUser"></textarea>
      <br><br>
      <!--<input type="submit" value="envoyer">-->
      <button type="submit" class="btn btn-primary" >Visualiser</button>
      </form>
    
  </div>
              <?php  
              
            }
            else{
                echo "<br><br> ERROR";
            }
            ?>
         

</body>
</html>

