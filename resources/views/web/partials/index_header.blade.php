  <header class="mdl-layout__header">

    <!-- Top Row always visible --> 
    <div class="mdl-layout__header-row">
      <!-- Title -->
      <h1 class="mdl-layout-title">Coding Resources</h1>

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

  <!-- Tabs -->
  <div class="mdl-layout__tab-bar mdl-js-ripple-effect">
    <a href="#tab_conferences" class="mdl-layout__tab is-active" @click.prevent="selectTab('conferences')">Conferences</a>
    <a href="#tab_articles" class="mdl-layout__tab" @click.prevent="selectTab('articles')">Articles</a>
    <a href="#tab_tutos" class="mdl-layout__tab" @click.prevent="selectTab('tutos')">Tutos</a>
    <a href="#tab_books" class="mdl-layout__tab" @click.prevent="selectTab('books')">Books</a>
  </div>

</header>
<div class="mdl-layout__drawer">
  <img src="{{ asset('img/nav_header.jpg') }}" class="nav_header"/>
  <span class="mdl-layout-title">Coding Resources</span>
  <ul>
    <li><a href="/proposition"><i class="material-icons">add_box</i>Add a link</a></li>
    <!-- <li><a href="/about"><i class="material-icons">assignment_ind</i>About</a></li> -->
    <li><a href="/contact"><i class="material-icons">mail</i>Contact</a></li>
  </ul>
  <hr>
  <div>
    <a href="https://play.google.com/store/apps/details?id=justme.application.com.newconfapp" target="_blank" rel="noopener noreferrer">
          <img src="{{ asset('img/google-play-badge.png') }}" alt="Google play badge" style="width:100%" />
    </a>
  </div>
</div>
<main class="mdl-layout__content" v-on:scroll="toggleNavBar">
  <section class="mdl-layout__tab-panel is-active" id="tab_conferences">
    <div class="page-content">
      <conferences namespace="conferences" tab="#tab_conferences"></conferences>
    </div>
  </section>
  <section class="mdl-layout__tab-panel" id="tab_articles">
    <div class="page-content">
      <articles namespace="articles" tab="#tab_articles"></articles>
    </div>
  </section>
  <section class="mdl-layout__tab-panel" id="tab_tutos">
    <div class="page-content">
      <tutos namespace="tutos" tab="#tab_tutos"></tutos>
    </div>
  </section>
  <section class="mdl-layout__tab-panel" id="tab_books">
    <div class="page-content">
      <books namespace="books" tab="#tab_books"></books>
    </div>
  </section>
</main>  
