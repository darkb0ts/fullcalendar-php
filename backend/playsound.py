import asyncio
import aiohttp
import json
import pygame

# Initialize Pygame
pygame.init()
mixer = pygame.mixer

async def play_audio():
    async with aiohttp.ClientSession() as session:
        async with session.get('http://localhost/calendar/backend/fetchapi.php') as response:
            if response.status == 200:
                try:
                    audio_data = await response.json()
                    audio_paths = [audio_item['audio'] for audio_item in audio_data]
                    for audio in audio_paths:
                        mixer.music.load("backend/"+audio)
                        mixer.music.play()
                        while mixer.music.get_busy():
                            await asyncio.sleep(0.1)
                except Exception as e:
                    print(f"Error: {e}")
            else:
                print(f"Request failed with status code: {response.status}")

# Run the async function
async def main():
    await play_audio()

if __name__ == '__main__':
    asyncio.run(main())
