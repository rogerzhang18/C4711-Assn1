<script type ='text/javascript'>
	function drag(target, event) {
        event.dataTransfer.setData("itemID", target.id);
        event.dataTransfer.setData("itemCategory", target.alt);
    }

    function drop(target, event) {
        var itemID = event.dataTransfer.getData("itemID");
        var itemCategory = event.dataTransfer.getData("itemCategory");
        // only allow dropping if correct item
        if (itemCategory.length > target.className.length)
        	return;
        var slotCategory = target.className.substring(0, itemCategory.length);
        if (itemCategory != slotCategory)
        	return;

        var origImg = document.getElementById(itemID);
        var copiedImg = origImg.cloneNode(true);
        copiedImg.setAttribute("id", target.className);
        target.innerHTML = "";
        target.appendChild(copiedImg);
        // prevent dragging from target
        // document.getElementById(data).setAttribute("draggable", "false")
    }

    function replaceImage(e) {
        if (e.selectedIndex < 3)
        {
        	document.getElementById("base-image").src = "./assets/img/background.png";
        	overlayImages(e.selectedIndex);
        }
        else
        {
	    	var target = document.getElementById("paste_stuff_here");
	    	target.innerHTML = "";
        	document.getElementById("base-image").src = "./assets/img/" + e.value + ".png";
        }
    }

    function overlayImages(index) {
    	var l1 = ["weapon_10", "weapon_8", "helmet_1", "glove_1", "boot_0", "chest_3", "amulet_2", "ring_0", "ring_0", "belt_0"]
    	var l2 = ["weapon_9" , "weapon_9", "helmet_3", "",        "boot_1", "chest_1", "amulet_0", "",       "",       "belt_3"]
    	var l3 = ["weapon_1" , "weapon_0", "helmet_0", "glove_3", "",       "chest_2", "amulet_1", "ring_1", "ring_1", "belt_1"]
    	var base = ["weapon_left", "weapon_right", "helmet", "glove", "boot", "chest", "amulet", "ring_left", "ring_right", "belt"]
    	var curr;
    	switch(index)
    	{
    		case 0:
    		curr = l1;
    			break;
    		case 1:
    		curr = l2;
    			break;
    		case 2:
    		curr = l3;
    			break;
    	}

    	var target = document.getElementById("paste_stuff_here");
    	target.innerHTML = "";
    	for (var i = curr.length - 1; i >= 0; i--) {
    		if (curr[i] == "")
    		{
    			continue;
    		}

        	var newImg = document.createElement('img');
        	newImg.setAttribute("id", base[i]);
        	newImg.setAttribute("src", "./assets/img/" + curr[i] + ".png");
    		target.appendChild(newImg);
    	}
    }
</script>
<style type="text/css">

	.imageWrapper {
	  position: relative;
	}	

	#chest {
		position: absolute;
		top: 200px;
		left: 247px;
	}

	#helmet {
		position: absolute;
		top: 100px;
		left: 251px;
	}

	#ring_left {
		position: absolute;
		top: 251px;
		left: 183px;
	}
	/*ring is 50x50, each slot is 50x50*/
	#ring_right {
		position: absolute;
		top: 251px;
		left: 368px;
	}

	#amulet {
		position: absolute;
		top: 193px;
		left: 368px;
	}

	#belt {
		position: absolute;
		top: 360px;
		left: 252px;
	}

	#glove {
		position: absolute;
		top: 312px;
		left: 135px;
	}

	#boot {
		position: absolute;
		top: 312px;
		left: 370px;
	}

	#weapon_left {
		position: absolute;
		top: 110px;
		left: 65px;
	}

	#weapon_right {
		position: absolute;
		top: 110px;
		left: 438px;
	}

</style>
<div class="POE_main">
	
		<h1 id="homepage-title">Welcome to Path of Exile custom mod!</h1>
		<div class="homepage-content">
            <div id="preset-dropdown">
            <select class="round" name="preset-dropdown" onchange="replaceImage(this);">
                {parts}
                  <option value={name}>{name}</option>
                {/parts}
            </select>
            </div>
            <div class="imageWrapper">
            	
        		<img id="base-image" src="./assets/img/background.png" />
        		<div id="paste_stuff_here"/>
        		<!-- for testing only -->
				<div class="chest" ondrop="drop(this, event)" ondragenter="return false" ondragover="return false" >
					<img id="chest" src="./assets/img/chest_slot.png" >
				</div>	
				<div class="helmet" ondrop="drop(this, event)" ondragenter="return false" ondragover="return false" >
					<img id="helmet" src="./assets/img/helmet_slot.png">
				</div>	
				<div class="glove" ondrop="drop(this, event)" ondragenter="return false" ondragover="return false" >
					<img id="glove" src="./assets/img/helmet_slot.png" >
				</div>	
				<div class="boot" ondrop="drop(this, event)" ondragenter="return false" ondragover="return false" >
					<img id="boot" src="./assets/img/helmet_slot.png" >
				</div>	
				<div class="ring_left" ondrop="drop(this, event)" ondragenter="return false" ondragover="return false" >
					<img id="ring_left" src="./assets/img/ring_slot.png">
				</div>	
				<div class="ring_right" ondrop="drop(this, event)" ondragenter="return false" ondragover="return false" >
					<img id="ring_right" src="./assets/img/ring_slot.png">
				</div>	
				<div class="amulet" ondrop="drop(this, event)" ondragenter="return false" ondragover="return false" >
					<img id="amulet" src="./assets/img/ring_slot.png">
				</div>	
				<div class="belt" ondrop="drop(this, event)" ondragenter="return false" ondragover="return false" >
					<img id="belt" src="./assets/img/belt_slot.png"				>
				</div>	
				<div class="weapon_left" ondrop="drop(this, event)" ondragenter="return false" ondragover="return false" >
					<img id="weapon_left" src="./assets/img/weapon_slot.png">
				</div>	
				<div class="weapon_right" ondrop="drop(this, event)" ondragenter="return false" ondragover="return false" >
					<img id="weapon_right" src="./assets/img/weapon_slot.png">
				</div>	
				<img id="ring_0" alt="ring" src="./assets/img/ring_0.png" draggable="true" ondragstart="drag(this, event)">
				<img id="chest_1" alt="chest" src="./assets/img/chest_1.png" draggable="true" ondragstart="drag(this, event)">
            </div>
            <p> This is a customized <strong>Path of Exile</strong> custom equipment build.</p>
            <p> The project consists of weapons and armors for the user to choose and build.</p>
            <p> We are dedicated provide the best gaming experience for you!</p>
		</div>
</div>
