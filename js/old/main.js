//Load settings from cookies
settings = new Settings();

var lowestNote = settings.lowestNote;
var highestNote = settings.highestNote;
var keysignature = settings.keysignature;
var withAccidental = settings.keysignature;

var firstNote,secondNote, lowestOctave, highestOctave;





setOctaves(2,6,true);
setKeySignature(keysignature)
setCurrentNote(generateRandomNote());
setSecondNote(generateRandomNote());


WebMidi.enable(function (err) {

    //Enable WebMidi
    if (err) {
      console.log("WebMidi could not be enabled.", err);
      window.alert("WebMidi is not supported by your Browser.\nPlease use Google Chrome or any other browser with WebMidi support!")
    } else {
      console.log("WebMidi enabled!");
    }
    
    //Populate DeviceList
    var select = document.getElementById( 'inputDeviceSelector' );
    for( i in WebMidi.inputs ) {
    
      var div = document.createElement("a");
      div.appendChild(document.createTextNode(WebMidi.inputs[i].name));
      div.style.cursor = "pointer";
      div.id = WebMidi.inputs[i].name;
      div.onclick=(function(val) { return function(){ selectInputDevice(val); }})(i);
      select.appendChild(div);

      
      var microphone = document.createElement("a");
      microphone.innerHTML= "Microphone";
      microphone.id = "microphone";
      microphone.style = "pointer";
      microphone.onclick=function(){microphoneInput()};
      select.appendChild(microphone);
    };

    //Select first found MidiDevice
    try {selectInputDevice(0);} 
    catch (error) {
      //ASK IF YOU SHOULD SELECT MICROPHONE beatufil popupshit
    }
    
    //draw first notes
    drawNote(getCurrentNote(),getSecondNote());
  });



function selectInputDevice(i){
  deselectAllInputs();
  document.getElementById("selectedDevice").innerHTML="Current device: " + WebMidi.inputs[i].name;
  document.getElementById(WebMidi.inputs[i].name).style="color: rgb(150,150,150)"
  document.getElementById(WebMidi.inputs[i].name).style.cursor = "not-allowed"
  console.log(i)
  startListening(i);
}

function startListening(i) {
    document.getElementById("combos").style.opacity=1;
    removeListeners();
    var input = WebMidi.inputs[i];
    console.log(input.id);

    input.addListener('noteon', "all",
    function (e) {
      receivedNote = e.note.name + "/" + e.note.octave;
      console.log("Received 'noteon' message (" + receivedNote + ").");
      console.log("Current Note" + getCurrentNote())

      if (checkNote(receivedNote)) {
        console.log("right, generating new note");
        inputIsRight()
      }
      else {
        console.log("wrong")
        inputIsWrong();
    }
      
    }
  );
}

function removeListeners() {
    for( i in WebMidi.inputs ) {WebMidi.inputs[i].removeListener()}
    try {stopTuner();}
    catch (error) {}
}

function checkNote(note){
  currentNote = getCurrentNote();
  
  //Change octave at b# and cb
  if (currentNote.includes("B#") == true){
    
    currentNote = currentNote.replace("B#","C");
    octave = parseInt(currentNote.slice(-1));
    currentNote = currentNote.replace(octave,octave+1);
    if (note == currentNote) {return true;}
    else {return false;}    
  }
  if (currentNote.includes("Cb") == true){
    currentNote = currentNote.replace("Cb","B");
    octave = parseInt(currentNote.slice(-1));
    currentNote = currentNote.replace(octave,octave-1);
    if (note == currentNote) {return true;}
    else {return false;}    
  }

  //Check if the note is affected by the current key signature
  currentNote = checkKeychangeKeySignature(keysignature,currentNote)

  //Replaces currentNote to match midi input (midi input is always C# not Db)
  
  currentNote = currentNote.replace("Db","C#");
  currentNote = currentNote.replace("Eb","D#");
  currentNote = currentNote.replace("E#","F");
  currentNote = currentNote.replace("Fb","E");
  currentNote = currentNote.replace("Gb","F#");
  currentNote = currentNote.replace("Ab","G#");
  currentNote = currentNote.replace("Bb","A#");

  //Check if MidiInput matches shown Note
  if (note == currentNote) {return true;}
  else {return false;}
}

//TEST ALL NOTES AND KEY SIGS

//Set and Get


//currentnote ändern
function inputIsRight()
{
  nextNote();
  answeredRight();  
  increaseCombo();
  increaseRight();
}

function setOctaves(low,high,init=false)
{
  document.getElementById("26").style="color: rgb(0,0,0), cursor=pointer"
  document.getElementById("17").style="color: rgb(0,0,0), cursor=pointer"
  document.getElementById("24").style="color: rgb(0,0,0), cursor=pointer"
  document.getElementById("46").style="color: rgb(0,0,0), cursor=pointer"
  lowestOctave = low;
  highestOctave = high;
  document.getElementById(String(low)+String(high)).style.cursor="not-allowed"
  document.getElementById(String(low)+String(high)).style.color="rgb(150,150,150)"
  if (init == false){ 
  resetNotes();
  }
}

function switchAccidentals(){
  if (withAccidental == true)
  {
    withAccidental = false;
    document.getElementById("accidentalSwitch").innerHTML = "♮";
    setCurrentNote(removeAccidental(getCurrentNote()));
    setSecondNote(removeAccidental(getSecondNote()));
    console.log(getCurrentNote(),(getSecondNote()));
  } 
  else
  {
    withAccidental = true;
    document.getElementById("accidentalSwitch").innerHTML = "♭ ♯";
    setCurrentNote(addAccidentalToNote(getCurrentNote()));
    setSecondNote(addAccidentalToNote(getSecondNote()));
    console.log(getCurrentNote(),getSecondNote());
  }
  drawNote(getCurrentNote(),getSecondNote());
}

function setKeySignature(selectedKeySignature = "random",init=false)
{
  settings.setKeysignature(selectedKeySignature);
  setKeySignatureDesignToDefault()
  switch (selectedKeySignature) {
    case "random":
      keysignature = generateRandomKeySignature();
      setCurrentKeySignatureToSelected();
      break;
    case "minor":
      keysignature = generateRandomKeySignature("minor");
      setCurrentKeySignatureToSelected();
      break;
    case "major":
      keysignature = generateRandomKeySignature("major");
      setCurrentKeySignatureToSelected();
      break;
    default:
      keysignature = selectedKeySignature;
      console.log(keysignature);
      setCurrentKeySignatureToSelected()
      break;
  
  }
  console.log("Selected key:" + keysignature)
  if (init == false){
    resetNotes();
  }
}

function getCurrentKeySignature() {return keysignature}

function setCurrentKeySignatureToSelected(){
  document.getElementById(keysignature).style.color="rgb(150,150,150)";
  document.getElementById(keysignature).style.cursor="not-allowed";
}

function setKeySignatureDesignToDefault() {
  document.getElementById("C").style="color: rgb(0,0,0), cursor=pointer";
  document.getElementById("F").style="color: rgb(0,0,0), cursor=pointer";
  document.getElementById("Bb").style="color: rgb(0,0,0), cursor=pointer";
  document.getElementById("Eb").style="color: rgb(0,0,0), cursor=pointer";
  document.getElementById("Ab").style="color: rgb(0,0,0), cursor=pointer";
  document.getElementById("Db").style="color: rgb(0,0,0), cursor=pointer";
  document.getElementById("Gb").style="color: rgb(0,0,0), cursor=pointer";
  document.getElementById("Cb").style="color: rgb(0,0,0), cursor=pointer";
  document.getElementById("G").style="color: rgb(0,0,0), cursor=pointer";
  document.getElementById("D").style="color: rgb(0,0,0), cursor=pointer";
  document.getElementById("A").style="color: rgb(0,0,0), cursor=pointer";
  document.getElementById("E").style="color: rgb(0,0,0), cursor=pointer";
  document.getElementById("B").style="color: rgb(0,0,0), cursor=pointer";
  document.getElementById("F#").style="color: rgb(0,0,0), cursor=pointer";
  document.getElementById("C#").style="color: rgb(0,0,0), cursor=pointer";
  document.getElementById("Am").style="color: rgb(0,0,0), cursor=pointer";
  document.getElementById("Dm").style="color: rgb(0,0,0), cursor=pointer";
  document.getElementById("Gm").style="color: rgb(0,0,0), cursor=pointer";
  document.getElementById("Cm").style="color: rgb(0,0,0), cursor=pointer";
  document.getElementById("Fm").style="color: rgb(0,0,0), cursor=pointer";
  document.getElementById("Bbm").style="color: rgb(0,0,0), cursor=pointer";
  document.getElementById("Ebm").style="color: rgb(0,0,0), cursor=pointer";
  document.getElementById("Abm").style="color: rgb(0,0,0), cursor=pointer";
  document.getElementById("Em").style="color: rgb(0,0,0), cursor=pointer";
  document.getElementById("Bm").style="color: rgb(0,0,0), cursor=pointer";
  document.getElementById("F#m").style="color: rgb(0,0,0), cursor=pointer";
  document.getElementById("C#m").style="color: rgb(0,0,0), cursor=pointer";
  document.getElementById("G#m").style="color: rgb(0,0,0), cursor=pointer";
  document.getElementById("D#m").style="color: rgb(0,0,0), cursor=pointer";
  document.getElementById("A#m").style="color: rgb(0,0,0), cursor=pointer";
}

function setCurrentNote(setNoteTo){firstNote = setNoteTo;}

function getCurrentNote(){return firstNote;}

function getAccidentalSwitch(){return withAccidental;}

function getLowestOctave(){return lowestOctave;}

function getHighestOctave() {return highestOctave;}

function setSecondNote(setNoteTo) {secondNote = setNoteTo}

function getSecondNote() {return secondNote}

function resetNotes()
{
  setCurrentNote(generateRandomNote());
  setSecondNote(generateRandomNote());
  drawNote(getCurrentNote(),getSecondNote())
}

function nextNote()
{
  setCurrentNote(getSecondNote());
  setSecondNote(generateRandomNote());
  console.log(getCurrentNote(),getSecondNote())
  drawNote(getCurrentNote(),getSecondNote());
}

function microphoneInput(){
  document.getElementById("combos").style.opacity=0;
  document.getElementById("selectedDevice").innerHTML="Current device: Microphone";
  deselectAllInputs();
  removeListeners();
  document.getElementById("microphone").style="color: rgb(150,150,150)"    
  document.getElementById("microphone").style.cursor = "not-allowed"
  startTuner();
}

function deselectAllInputs()
{
  document.getElementById("microphone").style="color: rgb(0,0,0)"    
  document.getElementById("microphone").style.cursor = "pointer"
  WebMidi.inputs.forEach(element => {
    document.getElementById(element.name).style="color: rgb(0,0,0)"    
    document.getElementById(element.name).style.cursor = "pointer"
    });
}

function inputIsWrong()
{
  answeredWrong();
  resetCombo();
  increaseWrong();
}