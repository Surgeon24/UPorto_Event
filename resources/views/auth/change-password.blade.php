<x-layout>
    <div class="login">
        <div class="gray">
            <h2>Change Password</h2>
            
            <form action="{{ url('profile/'. $user['id'].'/change-password') }}" method="POST">
                @csrf
        <div class="row g-3 align-items-center">
        <div class="col-auto">

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            <div class="col-auto">
                <label for="currentPassword" class="col-form-label" >Current Password</label>
            </div>    
            <div class="col-auto">
                <input type="password" id="currentPassword" name="currentPassword" class="form-control" aria-describedby="passwordHelpInline" placeholder="Enter Current Password">
                @error('currentPassword')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            
            </div>

            <div class="col-auto">
                <p></p>
                <label for="inputPassword6" class="col-form-label" >Password</label>
            </div>
            <div class="col-auto">
                <input type="password" id="inputPassword6" name="password" class="form-control" aria-describedby="passwordHelpInline" placeholder="Enter New Password" >
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <p></p>
        
            <div class="col-auto">
                <label for="confirmPassword" class="col-form-label" >Confirm Password</label>
            </div>
            <div class="col-auto">
                <input type="password" id="confirmPassword" name="password_confirmation" class="form-control"
                aria-describedby="passwordHelpInline" placeholder="Confirm New Password" >
                @error('password_confirmation')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
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