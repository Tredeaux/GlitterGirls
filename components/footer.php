<div class="footer">
    <div style="width:25%;"></div>
    <div style="width:50%;">
        <img style="margin-top:1vh;height:130px;"src="Images/gglogo_3.png">
        <br><br>
        <p>Glitter Girls Copyright &copy; <?php echo date("Y"); ?></p>
    </div>
    <div style="width:25%;">
        <div style="height:90%;"></div>
        <div style="height:10%;">
            <a href="../PHP/logout.php"><i class="fas fa-sign-out-alt"></i></a><button style="border:none;color:white;background-color:#333333;" onclick="showModal('modalAdmin')"><i class="fas fa-cog"></i></button> Developed by <a href="mailto:tredeaux.pitout@gmail.com">Tredeaux.P</a>
            <div>
                <div id="modalAdmin" class="modal">
                  <div class="modal-content">
                    <div style="width:790px;">                                        
                        <span onclick="closeModal(`modalAdmin`)" class="close">&times;</span>
                    </div>
                    <br>
                    <div>
                        <h5 style="color:black;">Admin console</h5>
                        <form style="text-align:center;" action="PHP/login.php" method="POST">
                            <br>
                            <input style="width:250px;" type="email" placeholder="Enter email" name="email" required>
                            <br>
                            <input style="width:250px;" type="password" placeholder="Enter password" name="password" required>
                            <br>            
                            <br>
                            <input class="subBut" style="cursor:pointer;"  type="submit" value="Login">
                        </form>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCrG_beoa7OIeg1CPTl4pyLSVfYcW0eKeU&callback=myMap"></script>
