import requests
import json
import pygame

pygame.init()
mixer = pygame.mixer

response = requests.get('http://localhost/calender/backend/fetchapi.php')

if response.status_code == 200:
    try:
        audio_data = json.loads(response.text)
        audio_paths = [audio_item['audio'] for audio_item in audio_data]
        for audio in audio_paths:
            mixer.music.load("backend/"+audio)
            mixer.music.play()
            while mixer.music.get_busy():
                pygame.time.wait(100)
    except:
        print("Error: Unable to parse JSON data from the response.")
else:
    print(f"Request failed with status code: {response.status_code}")
