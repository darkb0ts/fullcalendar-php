import pygame
import requests
import json
import time
import RPi.GPIO as GPIO  # Assuming Raspberry Pi GPIO library

default_audio = "/var/www/html/calendar/upload/school.mp3" #hardcore song
dir_path = "/var/www/html/calendar"

def get_data_from_api():
    try:
        response = requests.get('http://localhost/calendar/fetchapi.php')
        response.raise_for_status()
        try:
            data = response.json()
            return data
        except ValueError:
            print("No json data Present")
            return None
    except Exception as e:
        print(f"Error: {e}")
        time.sleep(1)

def play_audio(audio_path):
    """Plays a specified audio file using Pygame mixer."""
    try:
        pygame.mixer.music.load(audio_path)
        pygame.mixer.music.play()
        print("Playing audio:", audio_path)
        while pygame.mixer.music.get_busy():
            pygame.time.wait(100)
    except Exception as e:
        print("Error playing audio:", audio_path, e)

def main():
    pygame.init()
    pygame.mixer.init()

    # Button setup (assuming Raspberry Pi GPIO)
    button_pin = 17
    GPIO.setmode(GPIO.BCM)
    GPIO.setup(button_pin, GPIO.IN, pull_up_down=GPIO.PUD_UP)

    try:
        while True:
            # Check for API data
            audio_data = get_data_from_api()

            # Play audio from API response
            if audio_data:
                audio_paths = [audio_item['audio'] for audio_item in audio_data]
                for audio_path in audio_paths:
                    play_audio(str(dir_path)+audio_path)
                time.sleep(30)  # Delay after playing API audio

            # Check for button press
            button_state = GPIO.input(button_pin)
            if button_state == False:
                print("Button pressed")
                play_audio(default_audio)  # Replace with your desired button audio
                time.sleep(0.2)  # Delay after playing button audio

    except KeyboardInterrupt:  # Handle program termination gracefully
        pass  # No cleanup needed for pygame in this case

    finally:
        GPIO.cleanup()  # Cleanup GPIO pins (if applicable)
        pygame.quit()  # Quit Pygame

if __name__ == '__main__':
    main()
