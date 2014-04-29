//Castellanos Juarez Irvin
#include <stdio.h>
#include <stdlib.h>
#include <SDL/SDL.h>
#define ancho 600
#define largo 800
#define MAX 100
typedef struct carrito
{	SDL_Surface *img;
	SDL_Surface *img2;
}coche;
typedef struct carrin
{	int dato[3];
}CARRIN;
typedef struct cola
{	CARRIN d[MAX];
	int ini,fin,n;
}COLA;
int vacia(COLA C);
int eliminar(COLA *C,coche car[],SDL_Surface **screen,SDL_Surface *fondo);
void insertar(COLA *C,int in,coche car[],SDL_Surface **screen,SDL_Surface *fondo);
void movimiento(COLA *C,coche car[],SDL_Surface **screen,SDL_Surface *fondo,int n);
void movimiento_salida(COLA *C,coche car[],SDL_Surface **screen, SDL_Surface *fondo,int n);
void acomodar_salida(COLA *C,coche car[],SDL_Surface **screen, SDL_Surface *fondo,int n);
int main()
{	int n,i,j,opcion=-1;
	COLA C;
	C.ini=C.fin=C.n=0;
	printf("NOTA: mantener visble terminal\n");
//Inicializando SDL
	SDL_Surface *screen=NULL;
	SDL_Surface *fondo;
	SDL_Surface *arbol,*escenario[19];
	coche car[6];
	SDL_Rect pos;
	if(SDL_Init(SDL_INIT_VIDEO)<0)
	{	printf("Error en video\n");exit(1);}
	SDL_WM_SetCaption("Simulacion colas",NULL);
	screen=SDL_SetVideoMode(largo,ancho,24,SDL_SWSURFACE);
	if(screen==NULL)
	{	printf("Error al asignar video en memoria\n");exit(1);}
//escenario
	escenario[0]=SDL_LoadBMP("pino.bmp");
	escenario[1]=SDL_LoadBMP("piedra.bmp");
	escenario[2]=SDL_LoadBMP("letrero.bmp");
	escenario[3]=SDL_LoadBMP("ca.bmp");
	escenario[4]=SDL_LoadBMP("bull.bmp");
	escenario[5]=SDL_LoadBMP("arbol.bmp");
	escenario[6]=SDL_LoadBMP("arbol2.bmp");

//subiendo imagenes
	car[0].img=SDL_LoadBMP("mario1.bmp");
	car[0].img2=SDL_LoadBMP("mario2.bmp");
	car[1].img=SDL_LoadBMP("luigi1.bmp");
	car[1].img2=SDL_LoadBMP("luigi2.bmp");
	car[2].img=SDL_LoadBMP("tortuga1.bmp");
	car[2].img2=SDL_LoadBMP("tortuga2.bmp");
	car[3].img=SDL_LoadBMP("toad1.bmp");
	car[3].img2=SDL_LoadBMP("toad2.bmp");
	car[4].img=SDL_LoadBMP("peach1.bmp");
	car[4].img2=SDL_LoadBMP("peach2.bmp");	
	car[5].img=SDL_LoadBMP("bow1.bmp");
	car[5].img2=SDL_LoadBMP("bow2.bmp");
	fondo=SDL_LoadBMP("fondo.bmp");
	for(i=0; i<800; i+=60)
	{	for(j=0; j<600; j+=60)
		{	pos.x=i; pos.y=j;
			SDL_BlitSurface(fondo,NULL,screen,&pos);
		}
	}
	pos.y=370;
	for(i=250; i<1000; i+=70)
	{	pos.x=i;
                SDL_BlitSurface(escenario[5],NULL,screen,&pos);

	}
	for(i=0; i<400; i+=70)
	{	pos.x=20; pos.y=i;
		SDL_BlitSurface(escenario[5],NULL,screen,&pos);
	}
	for(i=0; i<400; i+=70)
        {       pos.x=170; pos.y=i;
                SDL_BlitSurface(escenario[5],NULL,screen,&pos);
        }
	pos.y=510;
	for(i=8; i<400; i+=60)
	{	pos.x=i;
		SDL_BlitSurface(escenario[3],NULL,screen,&pos);
	}
	pos.y=549;
        for(i=8; i<400; i+=66)
        {       pos.x=i;
                SDL_BlitSurface(escenario[3],NULL,screen,&pos);
        }
	pos.x=420;pos.y=530;
	SDL_BlitSurface(escenario[4],NULL,screen,&pos);
	pos.y=520;
	for(i=480; i<1000; i+=66)
        {       pos.x=i;
                SDL_BlitSurface(escenario[3],NULL,screen,&pos);
        }
	pos.x=467; pos.y=90;
        SDL_BlitSurface(escenario[0],NULL,screen,&pos);
	pos.x=240; pos.y=120;
        SDL_BlitSurface(escenario[0],NULL,screen,&pos);	
	pos.x=270; pos.y=210;
        SDL_BlitSurface(escenario[0],NULL,screen,&pos);
	pos.x=487; pos.y=9;
        SDL_BlitSurface(escenario[6],NULL,screen,&pos);
	pos.x=577; pos.y=190;
        SDL_BlitSurface(escenario[6],NULL,screen,&pos);

	

	pos.x=170; pos.y=410;
	SDL_BlitSurface(escenario[1],NULL,screen,&pos);
	pos.x=6; pos.y=400;
        SDL_BlitSurface(escenario[2],NULL,screen,&pos);	
	pos.x=6; pos.y=510;
	SDL_BlitSurface(escenario[3],NULL,screen,&pos);	
	pos.x=6; pos.y=549;
        SDL_BlitSurface(escenario[3],NULL,screen,&pos); 
	SDL_Flip(screen);
	//ciclo de modificaciones
	while(opcion!=0)
	{	printf("\n\nMenú:\n1)Insertar a la cola.\n2)Eliminar de la cola.\n0)salir\nopcion: ");
		scanf("%d",&opcion);
		switch(opcion)
		{	case 1:
			{	printf("\n\nCoches:\n1)Mario.\n2)Luigi.\n3)Tortuga.\n4)Toad\n5)peach.\n6)bow\n");
				scanf("%d",&n);
				insertar(&C,n-1,car,&screen,fondo);
				break;
			}
			case 2:
			{	eliminar(&C,car,&screen,fondo);	
				if(!vacia(C))
				{	 acomodar_salida(&C,car,&screen,fondo,C.n);}	
				break;
			}
		}
	}
        SDL_BlitSurface(car[1].img2,NULL,screen,&pos);
	SDL_Flip(screen);
	return 0;
}
void movimiento(COLA *C,coche car[],SDL_Surface **screen,SDL_Surface *fondo,int n)
{	SDL_Rect pos;
        pos.x=100;
	int i,j;
	
	for(j=0; j<400-(n*65);j+=2)
	{	SDL_BlitSurface(fondo,NULL,(*screen),&pos);
		pos.y=j;
		SDL_BlitSurface(car[C->d[C->fin%MAX].dato[2]].img,NULL,(*screen),&pos);
		
		C->d[n].dato[0]=pos.x;
		C->d[n].dato[1]=pos.y;
		
		SDL_Flip((*screen));
	}
	pos.y-=65;
	SDL_BlitSurface(fondo,NULL,(*screen),&pos);
	SDL_Flip((*screen));
}
void movimiento_salida(COLA *C,coche car[],SDL_Surface **screen, SDL_Surface *fondo,int n)
{	SDL_Rect pos;
	pos.x=100;pos.y=400;
	SDL_BlitSurface(fondo,NULL,(*screen),&pos);
	SDL_Flip((*screen));
	pos.y=446;
	SDL_BlitSurface(car[C->d[C->ini%MAX].dato[2]].img,NULL,(*screen),&pos);
	SDL_Flip((*screen));
	SDL_BlitSurface(fondo,NULL,(*screen),&pos);
	SDL_BlitSurface(car[C->d[C->ini%MAX].dato[2]].img2,NULL,(*screen),&pos);
	SDL_Flip((*screen));
	int i;
	pos.y=446;
	for(i=100; i<800; i+=4)
	{	SDL_BlitSurface(fondo,NULL,(*screen),&pos);
		pos.x=i;
		SDL_BlitSurface(car[C->d[C->ini%MAX].dato[2]].img2,NULL,(*screen),&pos);
		SDL_Flip((*screen));
	}
}
void acomodar_salida(COLA *C,coche car[],SDL_Surface **screen, SDL_Surface *fondo,int n)
{	int i,j;
	SDL_Rect pos;
	pos.x=100;
	for(i=C->ini,j=0; i<C->fin; i++,j++)
	{	pos.y=C->d[i].dato[1];
		SDL_BlitSurface(fondo,NULL,(*screen),&pos);
		pos.y=C->d[i].dato[1]+65;
		C->d[i].dato[1]=pos.y;
		SDL_BlitSurface(car[C->d[i].dato[2]].img,NULL,(*screen),&pos);	
		SDL_Flip(*screen);
	}
	SDL_Flip((*screen));	
	
}
int vacia(COLA C)
{	if(C.n==0)
		return 1;
	return 0;
}
void insertar(COLA *C,int in,coche car[],SDL_Surface **screen,SDL_Surface *fondo)
{	if(C->n==MAX)
	{	printf("Error Cola llena\n");exit(1);}
	C->d[C->fin%MAX].dato[2]=in;
	movimiento(C,car,screen,fondo,C->n);
	C->n++;
	C->fin++;
}
int eliminar(COLA *C,coche car[],SDL_Surface **screen,SDL_Surface *fondo)
{	if(vacia(*C))
	{	printf("Error cola vacia\n");exit(1);}
	int temp;
	movimiento_salida(C,car,screen,fondo,C->n);
	temp=C->d[C->ini%MAX].dato[2];
	C->ini++;
	C->n--;
	return temp;
}

