<diV class="row create-listing-panel">
    <div class="dropdown col-lg-5 col-md-5 ">
        <select class="form-control form-control-sm" id="categories" onChange="window.location.href=this.value">
            <option value="">Business Proposals by Categories</option>
            <?php
            $db = mysqli_connect($servername, $db_user, $db_password, $database);
            $sql = mysqli_query($db, "SELECT * FROM categories");
            while ($row = $sql->fetch_assoc()) {
                $slug = $row['slug'];
                $id = $row['id'];
                echo "<option value='categories.php?id=$id'>" . $row['description'] . "</option>";
            }
            ?>
        </select>
    </div>
    <div class="create-listing col-lg-2 col-md-3"><a href="create_listing.php"> <button type="button" class="btn btn-primary"><i class="fa fa-plus-square" aria-hidden="true"></i> Upload Idea</button></a></div>
    <div class="search-panel col-lg-5 col-md-4">
        <form class="d-flex" action="search.php" method="POST">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search" required>
            <button class="btn btn-primary" type="submit" name="search_submit">Search</button>
        </form>
    </div>

</diV>