#include <stdio.h>
#include <stdlib.h>
#include <SDL/SDL.h>
#define largo 600
#define ancho 800

int main()
{	int i;
	SDL_Surface *screen=NULL;
	if(SDL_Init(SDL_INIT_VIDEO)<0)
	{	printf("Error poca memoria\n");exit(1);}
	SDL_WM_SetCaption("Simulacion colas\n",NULL);
	screen=SDL_SetVideoMode(ancho,largo,24,SDL_SWSURFACE);
	if(screen==NULL)
	{	printf("Error en video =(\n");exit(1);}
	
	SDL_Surface *car;
	SDL_Rect pos;
	car=SDL_LoadBMP("azul1.bmp");
	for(i=0; i<300; i++)
	{	pos.x=300; pos.y=largo-i;
		SDL_BlitSurface(car,NULL,screen,&pos);
		SDL_Flip(screen);
		SDL_FillRect(screen,&pos,SDL_MapRGBA(screen->format,0,0,0,0));

	}
	int n=-1;
	while(n!=0)
	{	scanf("%d",&n);
		printf("x,y\n");
		scanf("%d",&pos.x);scanf("%d",&pos.y);
		SDL_BlitSurface(car,NULL,screen,&pos);
                SDL_Flip(screen);
                SDL_FillRect(screen,&pos,SDL_MapRGBA(screen->format,0,0,0,0));

        }

	
//	SDL_Delay(19000);
	int algo;
	scanf("%d",&algo);
	SDL_Quit();
	return 0;
}
