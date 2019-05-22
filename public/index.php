<?php 
    require_once '../admin/header.php';

    $page = 'index';
    loggedIn($page); //check if user is logged in
    
?>

<div class="content flex-col">
    <h1 class='heading-title'>
        Generate Substitute List
    </h1><!-- end .heading-title -->
    <div class="flex-center">
        <form action="display.php" method="get">
            <div class="form-group" id="date-field" >
                <label for="date">Select the date you need a substitute</label>
                <input type="date" name="date" id="date">
                <p class="error sunday-error show">*Date must be a Sunday</p>
                <p class="error blank-error show">*Select a Date</p>
                <p class="error future-error show">*Sunday must be after today</p>
            </div><!-- end .form-group -->
            <div class="form-group" id="type-field">
                <label for="subtype">Select the type of sub you need</label>
                <select name="type" id="type" size=8>
                    <option value="Teach a lesson for junior primary (Ages 3-7)">
                        Teach a lesson for junior primary (Ages 3-7)
                    </option>
                    <option value="Teach a lesson for senior primary (Ages 7-11)">
                        Teach a lesson for senior primary (Ages 7-11)
                    </option>
                    <option value="Be the second adult for junior primary (Ages 3-7)">
                        Be the second adult for junior primary (Ages 3-7)
                    </option>
                    <option value="Be the second adult for senior primary (Ages 7-11)">
                        Be the second adult for senior primary (Ages 7-11)
                    </option>
                    <option value="Help with junior nursery (Ages 18 months to 2 years)">
                        Help with junior nursery (Ages 18 months to 2 years)
                    </option>
                    <option value="Help with senior nursery (Ages 2 years to 3 years)">
                        Help with senior nursery (Ages 2 years to 3 years)
                    </option>
                    <option value="Lead the music">
                        Lead the music
                    </option>
                    <option value="Play the piano">
                        Play the piano
                    </option>
                </select>
                <p class="error show">*Select the type of substitute you need.</p>
            </div><!-- end .form-group -->

            <div class="form-group" id="gender">
                <label class="bold" for="gender">Gender: 
                    <span class="help-tip">
                        <p>Each primary class is required to have 2 teachers of the same gender or a married couple. This field helps narrow the subs to those that will honor this standard.</p>
                    </span><!-- end .help-tip -->
                </label><!--end bold -->
                
                <div class="gender">
                    <label for="male" class="inline-block">Male</label>
                    <input type="radio" name="gender" id="male" value="Male" class="inline-block" checked>
                    <label for="female" class="inline-block">Female</label>
                    <input type="radio" name="gender" id="female" value="Female" class="inline-block">
                </div><!-- end .gender -->
                <p class="error blank-error show">*Select a Gender</p>
            </div><!-- end .form-group #gender -->
            <input type="submit" value="Find a sub!">
        </form>
    </div><!-- end .flex-center -->
</div><!-- end .content -->

<?php require_once '../admin/footer.php'; ?>
