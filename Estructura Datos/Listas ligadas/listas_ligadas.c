//Irvin Castellanos Juarez 201-A
#include <stdio.h>
#include <stdlib.h>
#include <SDL/SDL.h>
#include <SDL_ttf.h>
#include <SDL_image.h>
#define alto 700
#define ancho 990
typedef struct nodo
{	int dato;
	struct nodo *sig;
	struct nodo *ant;
}NODO;
typedef NODO *PNODO;
typedef NODO *LISTA;

SDL_Surface *screen,*fondo,*ventana,*flecha,*flecha_iz;
TTF_Font *font,*font1,*font2;
void dibuja_lista(LISTA L);
void dibuja_linea(int x,int y,int w,int h,SDL_Color color);
void dibuja_principal();	
void print_on_screen(char *c,int x,int y,SDL_Color color,TTF_Font *fonti);
int ventana_insertar(char *c,int x,int y);
int ventana_pos(char *c,int x,int y,int *indice);
int ventana_eliminar_pos(char *c,int x,int y);

void eliminar_principio(LISTA *L);
void eliminar_final(LISTA *L);
int vacia(LISTA L);
void eliminar_por_posicion(LISTA *L,int n);
int tamano_lista(LISTA L);
void insertar_inicio(LISTA *L,int n);
void insertar_final(LISTA *L,int n);
void insertar_por_posicion(LISTA *L,int n,int indice);
int main()
{	//inicializando SDL
        if(SDL_Init(SDL_INIT_VIDEO)<0)
        {       printf("Error al establecer modo video\n");exit(1);}
        SDL_WM_SetCaption("Listas Doblemente ligadas",NULL);
        screen=SDL_SetVideoMode(ancho,alto,24,SDL_SWSURFACE);
        if(screen==NULL)
        {       printf("No se establecio el modo de video\n");
                exit(1);
        }
	TTF_Init();
	font=TTF_OpenFont("fonts/FortuneCity.ttf",20);
	font1=TTF_OpenFont("fonts/CaviarDreams_Bold.ttf",15);
	font2=TTF_OpenFont("fonts/FortuneCity.ttf",35);
	fondo=IMG_Load("fondo.jpg");
	ventana=IMG_Load("window1.png");
	flecha=IMG_Load("flecha.png");
	flecha_iz=IMG_Load("flecha_iz.png");
	//programa
	LISTA L;
	L=NULL;
	int opcion=-1,indice,numero;
	SDL_Event tecla;
	dibuja_principal();
        dibuja_lista(L);
	while(opcion!=0)
	{	SDL_WaitEvent(&tecla);
		if(tecla.type==SDL_KEYDOWN)
		{	switch(tecla.key.keysym.sym)
			{	case SDLK_1:
				{	insertar_inicio(&L,ventana_insertar("Insertar principio",430,260));
					dibuja_principal();
                			dibuja_lista(L);
					break;
				}
				case SDLK_2:
				{	numero=ventana_insertar("Insertar final",430,260);
					insertar_final(&L,numero);
                                       	dibuja_principal();
                                        dibuja_lista(L);
					break;
				}
				case SDLK_3:
				{	numero=ventana_pos("Insertar por posicion",430,260,&indice);
					insertar_por_posicion(&L,numero,indice);
					dibuja_principal();
                                        dibuja_lista(L);
					break;
				}
				case SDLK_4:
				{	eliminar_principio(&L);
					dibuja_principal();
                                        dibuja_lista(L);
					break;
				}
				case SDLK_5:
				{	eliminar_final(&L);
					dibuja_principal();
                                        dibuja_lista(L);
					break;
				}
				case SDLK_6:
				{	numero=ventana_eliminar_pos("Eliminar por posicion",430,260);
					eliminar_por_posicion(&L,numero);
					dibuja_principal();
                                        dibuja_lista(L);
					break;
				}
				case SDLK_0:
				{ opcion=0; break;}
				
			}
		}
	}
	SDL_FreeSurface(fondo);
	SDL_FreeSurface(ventana);
	SDL_FreeSurface(flecha);
	SDL_FreeSurface(flecha_iz);
	SDL_FreeSurface(screen);	
	SDL_Flip(screen);
	SDL_Quit();
}

void insertar_por_posicion(LISTA *L,int n,int indice)
{	if(indice<0 || indice>tamano_lista(*L))
	{	printf("ERROR INDICE INCORRECTO\n");
		return;
	}
	LISTA aux=*L;
	int i=0;
	if(indice==0)
	{	insertar_inicio(L,n);return;}
	if(indice==tamano_lista(*L))
	{	insertar_final(L,n);return;}
	while(aux!=NULL && indice>i)
	{	i++;
		aux=aux->sig;
	}
	PNODO nuevo=(PNODO)malloc(sizeof(NODO));
	nuevo->dato=n;
	nuevo->ant=aux->ant;
	(aux->ant)->sig=nuevo;
	nuevo->sig=aux;
	aux->ant=nuevo;
}
void eliminar_por_posicion(LISTA *L,int n)
{	if(*L==NULL)
	{	printf("ERROR LISTA VACIA\n");return;}
	if(n<0 || n>tamano_lista(*L))
	{	printf("Indice no existe\n");return;}
	if(tamano_lista(*L)==1)
	{	eliminar_principio(L);return;}
	if(n==tamano_lista(*L))
	{	eliminar_final(L);return;}
	LISTA aux=*L;
	while(aux->sig!=NULL)
		aux=aux->sig;
	(aux->ant)->sig=NULL;
	free(aux);
}
void eliminar_principio(LISTA *L)
{	if(*L==NULL)
	{ 	printf("ERROR LISTA VACIA\n");return ;}
	if(tamano_lista(*L)==1)
	{	free(*L);
		*L=NULL;
		return;
	}
	PNODO aux=*L;
	*L=aux->sig;
	(aux->sig)->ant=NULL;
	free(aux);
}
void eliminar_final(LISTA *L)
{	if(*L==NULL)
	{	printf("ERROR LISTA VACIA\n");return;}
	if(tamano_lista(*L)==1)
	{	eliminar_principio(L);return;}
	LISTA aux=*L;
	while(aux->sig!=NULL)
		aux=aux->sig;
	(aux->ant)->sig=NULL;
	free(aux);
}
int tamano_lista(LISTA L)
{	LISTA aux=L;
	int i=0;
	while(aux!=NULL)
	{	i++;
		aux=aux->sig;
	}
	return i;
}
void insertar_final(LISTA *L,int n)
{	if(*L==NULL)
		insertar_inicio(L,n);
	else
	{	PNODO nuevo=(PNODO)malloc(sizeof(NODO));
		nuevo->dato=n;
		nuevo->sig=NULL;
		LISTA aux=*L;
		while(aux->sig!=NULL)
			aux=aux->sig;
		aux->sig=nuevo;
		nuevo->ant=aux;
	}
}
int vacia(LISTA L)
{	if(L==NULL)
		return 1;
	return 0;
}

int ventana_eliminar_pos(char *c,int x,int y)
{	SDL_Rect pos;
        SDL_Color  color_l;
        color_l.r=73; color_l.g=93; color_l.b=222;
        pos.x=350; pos.y=250;
        SDL_BlitSurface(ventana,NULL,screen,&pos);
        print_on_screen(c,x,y,color_l,font);
        print_on_screen("Inserta una posicion y presiona",370,300,color_l,font);
        print_on_screen("[enter]",480,320,color_l,font);
        SDL_Flip(screen);
        int op=-1,n=0,aux=1;
        SDL_Event tecla;
        char cad[10];
        while(op!=0)
        {       SDL_WaitEvent(&tecla);
                if(tecla.type==SDL_KEYDOWN)
                {       switch(tecla.key.keysym.sym)
                        {       case SDLK_MINUS:
                                {        aux=-1; break;}
                                case SDLK_1:
                                {       n*=10;n+=1;break;}
                                case SDLK_2:
                                {      n*=10; n+=2;break;}
                                case SDLK_3:
                                {       n*=10;n+=3;break;}
                                case SDLK_4:
                                {       n*=10;n+=4;break;}
                                case SDLK_5:
                                {      n*=10; n+=5;break;}
                                case SDLK_6:
                                {       n*=10;n+=6;break;}
                                case SDLK_7:
                                {      n*=10;n+=7;break;}
                                case SDLK_8:
                                {       n*=10;n+=8;break;}
                                case SDLK_9:
                                {       n*=10;n+=9;break;}
                                case SDLK_0:
                                {       n*=10;break;}
                                case SDLK_RETURN:
                                {       op=0;break;}
                        }
                }
                sprintf(cad,"%d",n);
                SDL_Rect pox;pox.x=480;pox.y=390;pox.h=19;pox.w=19;
		 SDL_FillRect(screen,&pox,SDL_MapRGBA(screen->format,0,0,0,0));
                print_on_screen(&cad[0],480,390,color_l,font);
                SDL_Flip(screen);
        }
        return n*aux;
}

int ventana_pos(char *c,int x,int y,int *indice)
{	SDL_Rect pos;
        SDL_Color  color_l;
        color_l.r=73; color_l.g=93; color_l.b=222;
        pos.x=350; pos.y=250;
        SDL_BlitSurface(ventana,NULL,screen,&pos);
        print_on_screen(c,x,y,color_l,font);
        print_on_screen("Inserta una posicion y presiona",370,300,color_l,font);
        print_on_screen("[enter]",480,320,color_l,font);
        SDL_Flip(screen);
        int op=-1,n=0,aux=1;
        SDL_Event tecla;
        char cad[10];
	while(op!=0)
        {       SDL_WaitEvent(&tecla);
                if(tecla.type==SDL_KEYDOWN)
                {       switch(tecla.key.keysym.sym)
                        {       case SDLK_MINUS:
                                {        aux=-1; break;}
                                case SDLK_1:
                                {       n*=10;n+=1;break;}
                                case SDLK_2:
                                {      n*=10; n+=2;break;}
                                case SDLK_3:
                                {       n*=10;n+=3;break;}
                                case SDLK_4:
                                {       n*=10;n+=4;break;}
                                case SDLK_5:
                                {      n*=10; n+=5;break;}
                                case SDLK_6:
                                {       n*=10;n+=6;break;}
                                case SDLK_7:
                                {      n*=10;n+=7;break;}
                                case SDLK_8:
                                {       n*=10;n+=8;break;}
                                case SDLK_9:
                                {       n*=10;n+=9;break;}
                                case SDLK_0:
                                {       n*=10;break;}
                                case SDLK_RETURN:
                                {       op=0;break;}
                        }
                }
                sprintf(cad,"%d",n);
                SDL_Rect pox;pox.x=480;pox.y=390;pox.h=19;pox.w=19;
                SDL_FillRect(screen,&pox,SDL_MapRGBA(screen->format,0,0,0,0));
                print_on_screen(&cad[0],480,390,color_l,font);
		SDL_Flip(screen);
        }
	*indice=n*aux;
	
	pos.x=350; pos.y=250;
        SDL_BlitSurface(ventana,NULL,screen,&pos);
        print_on_screen(c,x,y,color_l,font);
        print_on_screen("Inserta un numero y presiona",370,300,color_l,font);
        print_on_screen("[enter]",480,320,color_l,font);
        SDL_Flip(screen);
        op=-1;n=0;aux=1;
         while(op!=0)
        {       SDL_WaitEvent(&tecla);
                if(tecla.type==SDL_KEYDOWN)
                {       switch(tecla.key.keysym.sym)
                        {       case SDLK_MINUS:
                                {        aux=-1; break;}
                                case SDLK_1:
                                {       n*=10;n+=1;break;}
                                case SDLK_2:
                                {      n*=10; n+=2;break;}
                                case SDLK_3:
                                {       n*=10;n+=3;break;}
                                case SDLK_4:
                                {       n*=10;n+=4;break;}
                                case SDLK_5:
                                {      n*=10; n+=5;break;}
                                case SDLK_6:
                                {       n*=10;n+=6;break;}
                                case SDLK_7:
                                {      n*=10;n+=7;break;}
                                case SDLK_8:
                                {       n*=10;n+=8;break;}
                                case SDLK_9:
                                {       n*=10;n+=9;break;}
                                case SDLK_0:
                                {       n*=10;break;}
                                case SDLK_RETURN:
                                {       op=0;break;}
                        }
                }
                sprintf(cad,"%d",n);
                SDL_Rect pox;pox.x=480;pox.y=390;pox.h=19;pox.w=19;
                SDL_FillRect(screen,&pox,SDL_MapRGBA(screen->format,0,0,0,0));
                print_on_screen(&cad[0],480,390,color_l,font);
		SDL_Flip(screen);
        }
	return n*aux;
}
void insertar_inicio(LISTA *L,int n)
{	PNODO nuevo=(PNODO)malloc(sizeof(NODO));
	if(nuevo==NULL)	
	{	printf("Error al crear nodo insertar inicio\n");
		exit(1);
	}
	nuevo->dato=n;
	nuevo->ant=NULL;
	if(*L==NULL)
	{	nuevo->sig=NULL;
		*L=nuevo;
	}
	else
	{	nuevo->sig=*L;
		(*L)->ant=nuevo;
		*L=nuevo;
	}
}

int ventana_insertar(char *c,int x,int y)
{	SDL_Rect pos;
	SDL_Color  color_l;
	color_l.r=73; color_l.g=93; color_l.b=222;
	pos.x=350; pos.y=250;
	SDL_BlitSurface(ventana,NULL,screen,&pos);
	print_on_screen(c,x,y,color_l,font);
	print_on_screen("Inserta un numero y presiona",370,300,color_l,font);
	print_on_screen("[enter]",480,320,color_l,font);	
	SDL_Flip(screen);
	int op=-1,n=0,aux=1;
	SDL_Event tecla;
	char cad[10];
	while(op!=0)
	{	SDL_WaitEvent(&tecla);
                if(tecla.type==SDL_KEYDOWN)
                {       switch(tecla.key.keysym.sym)
                        {       case SDLK_MINUS:
				{	 aux=-1; break;}
				case SDLK_1:
				{	n*=10;n+=1;break;}
				case SDLK_2:
                                {      n*=10; n+=2;break;}
                                case SDLK_3:
                                {       n*=10;n+=3;break;}
				case SDLK_4: 
                                {       n*=10;n+=4;break;}
				case SDLK_5: 
                                {      n*=10; n+=5;break;}
				case SDLK_6: 
                                {       n*=10;n+=6;break;}
				case SDLK_7: 
                                {      n*=10;n+=7;break;}
				case SDLK_8: 
                                {       n*=10;n+=8;break;}
				case SDLK_9: 
                                {       n*=10;n+=9;break;}
				case SDLK_0: 
                                {       n*=10;break;}
				case SDLK_RETURN: 
                                {       op=0;break;}
			}
		}
		sprintf(cad,"%d",n);
		SDL_Rect pox;pox.x=480;pox.y=390;pox.h=19;pox.w=19;
		SDL_FillRect(screen,&pox,SDL_MapRGBA(screen->format,0,0,0,0));
		print_on_screen(&cad[0],480,390,color_l,font);
		SDL_Flip(screen);	
	}
	return  n*aux;	
}
void print_on_screen(char *c,int x,int y,SDL_Color color,TTF_Font *fonti)
{	SDL_Rect pos;
	pos.x=x; pos.y=y;
	SDL_Surface *letras;
	letras=TTF_RenderText_Solid(fonti,c,color);
	SDL_BlitSurface(letras,NULL,screen,&pos);
//	SDL_Flip(screen);
}

void dibuja_linea(int x,int y,int w,int h,SDL_Color color)
{	SDL_Rect pos;
	pos.x=x; pos.y=y; pos.w=w; pos.h=h;
	SDL_FillRect(screen,&pos,SDL_MapRGBA(screen->format,color.r,color.g,color.b,0));
}
void dibuja_lista(LISTA L)
{	LISTA aux=L;
	char cadena[20];
	SDL_Rect posix,posflechasig,posflechaant;
	SDL_Color colors;
	colors.r=73; colors.g=93; colors.b=222;
	if(aux==NULL)
	{	 sprintf(cadena,"*L");
                 print_on_screen(cadena,145,60,colors,font1);
		 sprintf(cadena,"%p",L);
                 print_on_screen(cadena,145,90,colors,font1);
		 SDL_Flip(screen);
		return ;
	}
	posix.x=105; posix.y=95;
	posflechaant.x=10;posflechaant.y=135;
	posflechasig.x=225; posflechasig.y=100;
	while(aux!=NULL)
	{	dibuja_linea(posix.x,posix.y,130,2,colors);
		dibuja_linea(posix.x,posix.y+50,130,2,colors);
		dibuja_linea(posix.x,posix.y,2,50,colors);
		dibuja_linea(posix.x+130,posix.y,2,52,colors);
		dibuja_linea(posix.x+15,posix.y,2,50,colors);
		dibuja_linea(posix.x+115,posix.y,2,50,colors);
		if(aux==L)
		{	sprintf(cadena,"*L");
			print_on_screen(cadena,posix.x+50,posix.y-40,colors,font1);
		}
		sprintf(cadena,"%p",aux);
       	        print_on_screen(cadena,posix.x+12,posix.y-20,colors,font1);
		sprintf(cadena,"%d",aux->dato);
       	        print_on_screen(cadena,posix.x+45,posix.y+10,colors,font2);
		posix.x+=220;
		SDL_BlitSurface(flecha_iz,NULL,screen,&posflechaant);
		sprintf(cadena,"%p",aux->ant);
		print_on_screen(cadena,posflechaant.x+12,posflechaant.y-20,colors,font1);
		posflechaant.x+=220;
		SDL_BlitSurface(flecha,NULL,screen,&posflechasig);
                sprintf(cadena,"%p",aux->sig);
                print_on_screen(cadena,posflechasig.x+15,posflechasig.y-20,colors,font1);
                posflechasig.x+=220;
		if(posflechasig.x+80>ancho-10)
		{	posix.x=105; posix.y+=120;
        		posflechaant.x=10;posflechaant.y+=120;
        		posflechasig.x=225; posflechasig.y+=120;
		}
		aux=aux->sig;	
	}
	SDL_Flip(screen);
}
void dibuja_principal()
{	SDL_Color color;
	SDL_Color color_l;
	SDL_Rect pos;
	pos.x=0;pos.y=0;
	SDL_BlitSurface(fondo,NULL,screen,&pos);
	color_l.r=73; color_l.g=93; color_l.b=222;
	color.r=2; color.g=99; color.b=199;
	dibuja_linea(8,10,977,2,color);
	dibuja_linea(8,40,977,2,color);
	dibuja_linea(8,10,2,30,color);
	dibuja_linea(983,10,2,30,color);
	dibuja_linea(168,10,2,30,color);
	dibuja_linea(302,10,2,30,color);
	dibuja_linea(466,10,2,30,color);
	dibuja_linea(628,10,2,30,color);
	dibuja_linea(759,10,2,30,color);
	dibuja_linea(920,10,2,30,color);
	dibuja_linea(8,50,975,2,color);
	dibuja_linea(8,690,977,2,color);
	dibuja_linea(8,50,2,640,color);
	dibuja_linea(983,50,2,640,color);
	print_on_screen("1)Insertar principio 2)Insertar final 3)Insertar posicion 4)Eliminar principio 5)Eliminar final 6)Eliminar posicion 0)Salir",15,14,color_l,font);
}
