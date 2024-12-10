<div class="node" >

    <div class="user-circle" data-user-id="{{ $matrix2s->user_id }}" onclick="showUserData(this)" data-bs-toggle="modal" data-bs-target="#exampleModal">

        <i class="fas fa-user"></i>

    </div>

  {{ $user->username }}



  @if ($generation < 4)

  <div class="children">

     

      <div class="left-node">

          @if ($user->leftChild)

              <div class="line"></div>

              @include('user/dashboard/pages/stage2_node', ['user' => $user->leftChild, 'generation' => $generation + 1])

              

          @else

              <div class="line"></div>

             <div class="empty-node left-empty-node">+</div>

          @endif

      </div>

      <div class="right-node">

          @if ($user->rightChild)

              <div class="line"></div>

              @include('user/dashboard/pages/stage2_node', ['user' => $user->rightChild, 'generation' => $generation + 1])

          @else

              <div class="line"></div>

              <div class="empty-node right-empty-node">+</div>

          @endif

      </div>

  </div>

  @endif

</div>





  