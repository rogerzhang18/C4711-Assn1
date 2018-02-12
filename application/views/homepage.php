<div class="POE_main">
	<div> 
		<h1 id="homepage-title">Welcome to Path of Exile custom mod!</h1>
	        	

		<div class="homepage-content">
			<div>
				<!-- <form action="/homepage" method="post">
		        <select id="presetDropdown">Presets
		            <option value="background">Empty</option>
		            <option value="loadout_necromanger">Necromancer</option>
		            <option value="loadout_dragon">Dragon</option>
		            <option value="loadout_thief">Thief</option>
		        </select>
		        <button id="submitBtn" type="submit" value="insert">Confirm</button>
				</form> -->
				<div class="dropdown">
				  <button onclick="showDropdown()" class="dropbtn">Dropdown</button>
				  <div id="myDropdown" class="dropdown-content" style="display: none">
				    <div>
				    	<a href="/homepage/loadout_necromancer">Necromancer</a>
				    </div>
				    <div>
				    	<a href="/homepage/loadout_dragon">Elementalist</a>
				    </div>
				    <div>
				    	<a href="/homepage/loadout_thief">Shadow</a>
				    </div>
				  </div>
				</div>
			</div>
    
            <img src="<?php echo base_url('./assets/img/{preset}.png'); ?>" alt="preset goes here"/>
            <p> This is a customized <strong>Path of Exile</strong> custom equipment build.</p>
            <p> The project consists of weapons and armors for the user to choose and build.</p>
            <p> We are dedicated provide the best gaming experience for you!</p>
		</div>
	</div>
</div>
