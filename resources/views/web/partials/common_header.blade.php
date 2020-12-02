
  <header class="mdl-layout__header">

    <div aria-expanded="false" role="button" tabindex="0" class="mdl-layout__drawer-button back-button" @click.prevent="back"><i class="material-icons">arrow_back</i></div>

    <!-- Top Row always visible --> 
    <div class="mdl-layout__header-row">
      <!-- Title -->
      <span class="mdl-layout-title">{{ $title }}</span>

      <div class="mdl-layout-spacer"></div>
      <div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable mdl-textfield--floating-label mdl-textfield--align-right" id="searchField">
        <label class="mdl-button mdl-js-button mdl-button--icon" for="fixed-header-drawer-exp">
          <i class="material-icons" @click="launchSearch">search</i>
        </label>

        <i class="material-icons search-close" v-if="search.length > 0" @click="clearSearch" v-cloak>close</i>

      <div class="mdl-textfield__expandable-holder">
        <input class="mdl-textfield__input" type="text" name="search" v-model="search" 
          id="fixed-header-drawer-exp" autocomplete="off" @keypress.enter="launchSearch">
      </div>    
    </div>
  <!-- Suggestions -->
    <suggestions :suggestions="suggestions"></suggestions>
  </div>

</header>
