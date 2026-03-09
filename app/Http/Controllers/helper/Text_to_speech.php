<?php

namespace App\Http\Controllers\helper;

use App\Http\Controllers\Controller;
use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;
use Illuminate\Http\Request;

class Text_to_speech extends Controller
{
    public function convert(Request $request)
    {
        $txt = $request->text;
        $txt = 'شرائط قياس السكر فى الدم من Yuwell Check عبوة 50 شريط قياس';
        $txt = htmlspecialchars($txt);
        $txt = rawurlencode($txt);
        $html = file_get_contents('https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q='.$txt.'&tl=en-US');
        $player = "<audio controls='controls' autoplay><source src='data:audio/mpeg;base64,".base64_encode($html)."'></audio>";
        echo $player;
    }

    public static function TextToSpeech(Request $request)
    {
        $textToSpeechClient = new TextToSpeechClient;
        $input = new SynthesisInput;
        $input->setText($request->text);
        $voice = new VoiceSelectionParams;
        $voice->setLanguageCode('en-US');
        $voice->setName('en-US-Standard-A');
        $audioConfig = new AudioConfig;
        $audioConfig->setAudioEncoding(AudioEncoding::MP3);

        $resp = $textToSpeechClient->synthesizeSpeech($input, $voice, $audioConfig);
        public_path('text_to_speech/'.file_put_contents($request->text.'.mp3', $resp->getAudioContent()));

        return public_path('text_to_speech/'.$request->text.'.mp3');
    }

    public static function service_account_file()
    {
        return file_get_contents(public_path().'/secure-granite-352103-a5e19321ff0a.json');
    }
}
