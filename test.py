import pygame
import sys

pygame.mixer.init()
pygame.mixer.music.load(sys.argv[1])
pygame.mixer.music.play()

while pygame.mixer.music.get_busy() == True:
    continue
