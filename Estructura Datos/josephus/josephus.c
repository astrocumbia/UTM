//Irvin Castellanos Juarez 201-A

#include <stdio.h>
#include <stdlib.h>
#include <SDL/SDL.h>
#include <SDL_image.h>
#define alto 700
#define ancho 900
typedef struct nodo
{	SDL_Rect pos;
	struct nodo* sig;
	struct nodo* ant;
}NODO;
typedef NODO *PNODO;
typedef NODO *LISTA;
void insertar(LISTA *L);
void pintar(LISTA L);
void eliminar(LISTA *L,int n);
void quema(int x,int y);
SDL_Surface *screen,*fondo,*sprites[5],*explo[12];
int main()
{	int tipos,n,i,k;
	char c[20];
	LISTA L;
	L=NULL;
	printf("Ingresa el numero de prisioneros:\n");
	scanf("%d",&tipos);
	printf("Ingresa el numero a matar\n");
	scanf("%d",&n);
	for(i=0; i<tipos; i++)
	{	insertar(&L);
	}

	//inicializando SDL
        if(SDL_Init(SDL_INIT_VIDEO)<0)
        {       printf("Error al establecer modo video\n");exit(1);}
        SDL_WM_SetCaption("Listas Doblemente ligadas",NULL);
        screen=SDL_SetVideoMode(ancho,alto,24,SDL_SWSURFACE);
        if(screen==NULL)
        {       printf("No se establecio el modo de video\n");
                exit(1);
        }
	for(i=0,k=1; i<5;k++, i++)
	{	sprintf(c,"sprites/%d.png",k);
		sprites[i]=IMG_Load(c);
		if(sprites[i]==NULL)
			printf("Error al cargar\n");
	}
	for(i=0,k=1; i<12;k++, i++)
        {       sprintf(c,"sprites/e%d.png",k);
                explo[i]=IMG_Load(c);
                if(explo[i]==NULL)
                        printf("Error al cargar explo %d\n",i);
        }
	fondo=IMG_Load("sprites/fondo.jpg");
	pintar(L);
	for(i=0; i<tipos-1; i++)
	{	eliminar(&L,n);
		SDL_Delay(800);}	
	SDL_Quit();
	return 0;
}
void eliminar(LISTA *L,int n)
{	if(*L==NULL)
	{	printf("Error\n");return;}
	if((*L)->sig==*L)
	{	int x,y;
		x=((*L)->pos).x;
		y=((*L)->pos).y;//llamar a quemar 
		quema(x,y);
		free(*L);
		*L=NULL;
	}
	int i=0;
	while(i<n)
	{	i++;
		*L=(*L)->sig;
	}
	int x,y;
	LISTA aux=(*L)->ant;
	x=(aux->pos).x;
        y=(aux->pos).y;
	quema(x,y);
	printf("CAMBIOS LIGAS\n");
	(((*L)->ant)->ant)->sig=*L;
	(*L)->ant=((*L)->ant)->ant;
	free(aux);
}
void quema(int x,int y)
{	SDL_Rect pos;
	pos.x=x; pos.y=y;
	int i;
	for(i=0; i<5; i++)
	{	SDL_BlitSurface(fondo,NULL,screen,&pos);
		SDL_BlitSurface(sprites[i],NULL,screen,&pos);
		SDL_Flip(screen);
		SDL_Delay(150);
	}
	for(i=0; i<11; i++)
	{	SDL_BlitSurface(explo[i],NULL,screen,&pos);
                SDL_Flip(screen);
                SDL_Delay(150);
	}
}
void pintar(LISTA L)
{	if(L==NULL)
	{	printf("Vacia\n");}
	LISTA aux=L->sig;
	SDL_BlitSurface(sprites[0],NULL,screen,&(L->pos));
	while(aux!=L)
	{	SDL_BlitSurface(sprites[0],NULL,screen,&(aux->pos));
		aux=aux->sig;
	}
	SDL_Flip(screen);
	
}
void insertar(LISTA *L)
{	PNODO nuevo=(PNODO)malloc(sizeof(NODO));
	if(*L==NULL)
	{	*L=nuevo;
		nuevo->sig=*L;
		nuevo->ant=*L;
		(nuevo->pos).x=10;
	        (nuevo->pos).y=250;
	}
	else
	{	LISTA aux=(*L)->sig;
		while(aux->sig!=*L)
			aux=aux->sig;
		aux->sig=nuevo;
		nuevo->ant=aux;
		nuevo->sig=*L;
		(*L)->ant=nuevo;
		(nuevo->pos).x=((nuevo->ant)->pos).x+60;
	        (nuevo->pos).y=250;
		 printf("x %d y %d\n",(nuevo->pos).x,(nuevo->pos).y);
	}
	 
}
