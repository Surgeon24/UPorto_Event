<x-layout>
    <style>
        .gray{
           position: relative;
           padding: 50px;
           text-align: center;
           background-color: rgba(0, 0, 0, 0.8);
           color: white;       
         }
    
        .bar{
      background-color:#363230;
      color:white;
      border-radius: 15px;
      border: 1px #000 solid;
        }
    
        .login{
            position: absolute;
            top: 50%;
            left: 50%;
            margin: -150px 0 0 -150px;
            width:400px;
            height:300px;
        }
        .error{
            color: red;
            text-emphasis: xs;
            margin-top: 1;
            
            /* text-red-500 text-xs mt-1 */
        }
    </style>
    
    <div class="login"> 
    <div class="gray">
        <h1>Create new poll</h1>
        <form method="post" action="{{ route('create_poll', $event->id) }}" accept-charset="UTF-8" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="question">Question</label>
                <input class="form-control" type="text" id="question" name="question" placeholder="Put the question of the poll" required>
                @error('question')
                    <p class="error">{{$message}}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="option_1">Option 1</label>
                <input class="form-control" type="text" id="option_1" name="option_1" placeholder="..." required>
                @error('option_1')
                    <p class="error">{{$message}}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="option_2">Option 2</label>
                <input class="form-control" type="text" id="option_2" name="option_2" placeholder="..." required>
                @error('option_2')
                    <p class="error">{{$message}}</p>
                @enderror
            </div>
            <div id="additional-options"></div>
            <!-- Add a button to add more options -->
            <button type="button" class="btn btn-success" style="background-color:rgb(140, 18, 18)" onclick="removeOption()"><i class="fas fa-minus"></i> Remove option</button>
            <button type="button" class="btn btn-success" onclick="addOption()"><i class="fas fa-plus"></i> Add option</button>
            <p></p>
            <button type="submit" class="btn btn-primary btn-block btn-large">Submit</button>
        </form>
    </div>
    </div>
    
    
    <script>
        // Initialize the option counter
        let optionCounter = 2;
      
        // Function to add a new option input field
        function addOption() {
          optionCounter++;
          const newOption = document.createElement("div");
          newOption.setAttribute("class", "form-group");
          newOption.setAttribute("id", `option-${optionCounter}`);
          newOption.innerHTML = `<label for="option_${optionCounter}">Option ${optionCounter}</label><input class="form-control" type="text" id="option_${optionCounter}" name="option_${optionCounter}" placeholder="...">`;
          document.getElementById("additional-options").appendChild(newOption);
        }


        function removeOption() {
        var x = document.getElementById("additional-options");
        optionCounter--;
        x.removeChild(x.lastElementChild);

        }

    </script>


</x-layout>