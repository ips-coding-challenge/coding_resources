  <header class="mdl-layout__header">

    <div aria-expanded="false" role="button" tabindex="0" class="mdl-layout__drawer-button back-button" @click.prevent="back">
        <i class="material-icons">arrow_back</i>
    </div>

    <!-- Top Row always visible --> 
    <div class="mdl-layout__header-row">
      <!-- Title -->
      <h1 class="mdl-layout-title">{{ $title }}</h1>          
    </div>

</header>
