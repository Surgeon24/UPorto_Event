<x-layout>
    <div class="login">
        <div class="gray">
            <h2>Change Password</h2>
            
            <form action="{{ url('profile/'. $user['id'].'/change-password') }}" method="POST">
                @csrf
        <div class="row g-3 align-items-center">
        <div class="col-auto">

            <div class="col-auto">
                <label for="currentPassword" class="col-form-label" >Current Password</label>
            </div>    
            <div class="col-auto">
            <input type="password" id="currentPassword" name="currentPassword" class="form-control" aria-describedby="passwordHelpInline" required>
            </div>

            <div class="col-auto">
                <p></p>
                <label for="inputPassword6" class="col-form-label" >Password</label>
            </div>
            <div class="col-auto">
                <input type="password" id="inputPassword6" name="newPassword" class="form-control" aria-describedby="passwordHelpInline" required>
            </div>
            <div class="col-auto">
                <span id="passwordHelpInline" class="form-text">Must be 8-20 characters long.</span>
            </div>
            <p></p>
        
            <div class="col-auto">
                <label for="confirmPassword" class="col-form-label" >Confirm Password</label>
            </div>
            <div class="col-auto">
                <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" aria-describedby="passwordHelpInline" required>
            </div>

            <p></p>
            <button type="submit" class="btn btn-warning">
                Confirm
            </button>
      </div>
    </form>
   
    </div>
</div>
</x-layout>