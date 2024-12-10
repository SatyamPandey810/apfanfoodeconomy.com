<div class="node" >
    <div class="user-circle" data-user-id="{{ $user->user_id }}" onclick="showUserData(this)" data-bs-toggle="modal" data-bs-target="#exampleModal">
        <i class="fas fa-user"></i>
    </div>
  {{ $user->username }}

  @if ($generation < 3)
  <div class="children">
     
      <div class="left-node">
          @if ($user->leftChild)
              <div class="line"></div>
              @include('user/dashboard/pages/binary_tree_node', ['user' => $user->leftChild, 'generation' => $generation + 1])
              
          @else
              <div class="line"></div>
              <a href="{{ route('user.link.register', ['user_id' => $user->user_id ,'current_user' => $currentUsers , 'position'=> 'L']) }}"><div class="empty-node left-empty-node">+</div></a>
          @endif
      </div>
      <div class="right-node">
          @if ($user->rightChild)
              <div class="line"></div>
              @include('user/dashboard/pages/binary_tree_node', ['user' => $user->rightChild, 'generation' => $generation + 1])
          @else
              <div class="line"></div>
              <a href="{{ route('user.link.register', ['user_id' => $user->user_id ,'current_user' => $currentUsers,'position'=> 'R'])}}"><div class="empty-node right-empty-node">+</div></a>
          @endif
      </div>
  </div>
  @endif
</div>
<form action="{{ route('getUser.SponsorInfos') }}" method="POST" id="userForm" style="display: none;">
    @csrf
    <input type="hidden" name="user_id" id="user_id_input">
</form>

<script>
function showUserData(element) {
    const userId = element.getAttribute('data-user-id');
    document.getElementById('user_id_input').value = userId;
    
    document.getElementById('userForm').submit();
}
</script>


  