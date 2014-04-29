#include <stdio.h>
#include <stdlib.h>
#include <SDL/SDL.h>
#include <SDL_image.h>
#include <SDL_ttf.h>
#define ancho 1000       
#define alto 600
typedef struct vec
{	int n;
	SDL_Rect pos;
}BURBUJAS;
SDL_Surface *screen,*insertar_dato,*acerca,*imagen_cuadrito,*si,*no,*entrada,*burbuja_imagen,*background;

FILE *datos_archivo;
BURBUJAS datos[15];
int cantidad,aleatorio,salir;
TTF_Font *font_num,*fontmax,*font; 
SDL_Color color1;

void pintar_burbujas(int a,int b);
void Load_image(SDL_Surface **image,char *ptr);
void cargando_interface();
void acercade();
void generar_random();
void simulacion_burbuja();
void print_on_screen(char *c,int x,int y,SDL_Color color,TTF_Font *fonti);
void movimiento_burbuja(int a,int b);
void burbuja(int n);
void movimiento_burbuja_regreso(int a,int b);
void cambio_bubujazo(int a,int b,int x,int y);
void ventana_entrada();
int posicion_cursor(int xi,int xf,int yi,int yf,int mousex,int mousey);
void modificando_datos();
void imprimir_datos();
int teclado(int xi,int xf,int yi,int yf);

int main(int argc, char *argv[])
{	//inicializando SDL
        if(SDL_Init(SDL_INIT_VIDEO)<0)
        {       printf("Error al establecer modo video\n");exit(1);}
        SDL_WM_SetCaption("Prueba_botones",NULL);
        screen=SDL_SetVideoMode(ancho,alto,24,SDL_SWSURFACE);
        if(screen==NULL)
        {       printf("No se establecio el modo de video\n");
                exit(1);
        }	
        //font
        TTF_Init();
	//programa
	
	cargando_interface();
	ventana_entrada();
	SDL_Quit();
}
void imprimir_datos()
{	char c[10];
	sprintf(c,"%d",cantidad);
	print_on_screen(&c[0],416,110,color1,fontmax);
	SDL_Rect linea={150,300,1,40},rectangulo={150,300,cantidad*40,40};
	SDL_FillRect(screen,&rectangulo,SDL_MapRGBA(screen->format,255,255,255,30));
	int i;
	for(linea.x=150,i=0; i<cantidad; i++,linea.x+=40)
	{	SDL_FillRect(screen,&linea,SDL_MapRGBA(screen->format,0,0,0,30));
		sprintf(c,"%d",datos[i].n);
		print_on_screen(&c[0],linea.x+12,300,color1,font);
	}
	
}
void modificando_datos()
{	SDL_Rect pos;
	char c[10];
	pos.x=0; pos.y=0;
	SDL_BlitSurface(background,NULL,screen,&pos);
	SDL_BlitSurface(insertar_dato,NULL,screen,&pos);
	SDL_Flip(screen);
	SDL_Event eventin;
	while(1)
	{	SDL_WaitEvent(&eventin);
		if(eventin.type==SDL_MOUSEBUTTONDOWN)
		{	if(posicion_cursor(416,536,110,172,eventin.button.x,eventin.button.y))
			{	cantidad=teclado(416,536,110,172);
				SDL_BlitSurface(background,NULL,screen,&pos);
        			SDL_BlitSurface(insertar_dato,NULL,screen,&pos);
				imprimir_datos();
        			SDL_Flip(screen);
			}
			else if(posicion_cursor(164,370,460,500,eventin.button.x,eventin.button.y))
			{	aleatorio=1; generar_random();}
			else if(cantidad!=0 && posicion_cursor(630,843,460,500,eventin.button.x,eventin.button.y))
                        {       if(aleatorio==0)
				{	generar_random();}	
				return;
			}

		}
		
		
	}		
	SDL_Flip(screen);
}
void generar_random()
{	int i,hora=time(NULL);
	srand(hora);
	for(i=0; i<cantidad; i++)
		datos[i].n=rand()%99;
	imprimir_datos();
	SDL_Flip(screen);

}
int teclado(int xi,int xf,int yi,int yf)
{	int n=0,k=1;
	SDL_Rect rec={xi,yi,xf-xi,yf-yi};
	SDL_Event event1;
	char c[40];
	SDL_FillRect(screen,&rec,SDL_MapRGBA(screen->format,255,255,255,30));
	sprintf(c,"Presiona [enter] para grabar ");
	print_on_screen(&c[0],xf+5,yi,color1,font);
	SDL_Flip(screen);
	while(1)
	{	SDL_WaitEvent(&event1);
		if(event1.type==SDL_KEYDOWN)
                {       switch(event1.key.keysym.sym)
                        {       case SDLK_1:
				{n*=10; n+=1;break;}
				case SDLK_2:
                                {n*=10; n+=2;break;}
				case SDLK_3:
                                {n*=10; n+=3;break;}
				case SDLK_4:
                                {n*=10; n+=4;break;}
				case SDLK_5:
                                {n*=10; n+=5;break;}
				case SDLK_6:
                                {n*=10; n+=6;break;}
				case SDLK_7:
                                {n*=10; n+=7;break;}
				case SDLK_8:
                                {n*=10; n+=8;break;}
				case SDLK_9:
                                {n*=10; n+=9;break;}
				case SDLK_0:
                                {n*=10;break;}
				case 8:
				{	n/=10; break;}
				case SDLK_MINUS:
				{	k=-1; break;}
				case SDLK_RETURN:
					if(n<15)
						return k*n;
			
			}
			if(n>99)
				n/=10;
			sprintf(c,"%d",n);
			SDL_FillRect(screen,&rec,SDL_MapRGBA(screen->format,255,255,255,30));
			print_on_screen(&c[0],xi,yi,color1,fontmax);
			SDL_Flip(screen);
		}
	}
}
void ventana_entrada()
{	SDL_Rect pos;
	pos.x=0; pos.y=0;
	SDL_BlitSurface(entrada,NULL,screen,&pos);
	SDL_Flip(screen);
	cantidad=0;aleatorio=0;
	int i;
	for(i=0; i<15; i++)
		datos[i].n=0;	
	SDL_Event eventito;
	while(1)
	{	SDL_WaitEvent(&eventito);
                if(eventito.type==SDL_MOUSEBUTTONDOWN)
                {	if(posicion_cursor(440,970,110,184,eventito.button.x,eventito.button.y))
			{	modificando_datos();
				simulacion_burbuja();
			}
			else if(posicion_cursor(440,970,210,276,eventito.button.x,eventito.button.y))	
			{	acercade();
				pos.x=0; pos.y=0;
			        SDL_BlitSurface(entrada,NULL,screen,&pos);
    				 SDL_Flip(screen);
			}
			else if(posicion_cursor(440,970,304,376,eventito.button.x,eventito.button.y))
			{	SDL_FreeSurface(screen);	
				SDL_Quit();
				exit(1);
			}
		}
	}
	SDL_Delay(10000);
}
void acercade()
{	SDL_Rect pos;
	pos.x=0; pos.y=0;
	SDL_BlitSurface(acerca,NULL,screen,&pos);
	SDL_Event event1;
	SDL_Flip(screen);
	while(1)
	{
		SDL_WaitEvent(&event1);
                if(event1.type==SDL_KEYDOWN && event1.key.keysym.sym==27)
			return;
	}
}
void burbuja(int n)
{       SDL_Rect pos;
	int x,y;
	char c[20];
	SDL_Event event;
	int i,j,temp;
        for(i=0; i<n; i++)
        {       for(j=0; j<n-(i+1); j++)
                {       if(SDL_PollEvent(&event))
                	        if(event.type==SDL_KEYDOWN  && event.key.keysym.sym)
                        	{      ventana_entrada();
                        	}
        	        movimiento_burbuja(j,j+1);
			pos.x=datos[j].pos.x+10;x=pos.x;
			pos.y=datos[j].pos.y-35;y=pos.y;
			SDL_BlitSurface(imagen_cuadrito,NULL,screen,&pos);
			sprintf(c,"%d > %d ?",datos[j].n,datos[j+1].n);
			print_on_screen(&c[0],pos.x+8,pos.y+10,color1,font);
			SDL_Flip(screen);
			SDL_Delay(800);
			if(datos[j].n>datos[j+1].n)
                        {       pos.x+=76;pos.y+=3;
				SDL_BlitSurface(si,NULL,screen,&pos);
				SDL_Flip(screen);
				SDL_Delay(200);
				cambio_bubujazo(j,j+1,x,y);
				temp=datos[j].n;
                                datos[j].n=datos[j+1].n;
                                datos[j+1].n=temp;
                        }
			else
			{	pos.x+=76;pos.y+=3;
                                SDL_BlitSurface(no,NULL,screen,&pos);
                                SDL_Flip(screen);
				SDL_Delay(200);
			}
			movimiento_burbuja_regreso(j,j+1);

                }
        }
}
void cambio_bubujazo(int a,int b,int x,int y)
{	char c[20];
	SDL_Rect posa,posb,pos,posi;posi.x=0; posi.y=0;
	posa.x=datos[a].pos.x; posa.y=datos[a].pos.y+25;
	posb.x=datos[b].pos.x; posb.y=datos[b].pos.y+25;
	for( ; posa.x<datos[b].pos.x; posa.x+=10,posb.x-=10)
	{	SDL_Delay(180);
		SDL_BlitSurface(background,NULL,screen,&posi);
		pintar_burbujas(a,b);
		pos.x=x;pos.y=y;
		SDL_BlitSurface(imagen_cuadrito,NULL,screen,&pos);
                sprintf(c,"%d > %d ?",datos[a].n,datos[b].n);
                print_on_screen(&c[0],pos.x+8,pos.y+10,color1,font);
		if(datos[a].n>datos[b].n)
                {	pos.x+=76;pos.y+=3;
                        SDL_BlitSurface(si,NULL,screen,&pos);
		}
		else
		{	pos.x+=76;pos.y+=3;
                        SDL_BlitSurface(no,NULL,screen,&pos);
		}
		sprintf(c,"%d",datos[a].n);
		print_on_screen(&c[0],posa.x+20,posb.y+12,color1,font_num);
		SDL_BlitSurface(burbuja_imagen,NULL,screen,&posa);
		sprintf(c,"%d",datos[b].n);
		print_on_screen(&c[0],posb.x+20,posb.y+12,color1,font_num);
		SDL_BlitSurface(burbuja_imagen,NULL,screen,&posb);
		SDL_Flip(screen);
	}
}
void movimiento_burbuja(int a,int b)
{	SDL_Rect posa,posb,pos;pos.x=0;pos.y=0;
	
	SDL_Event event;
	
	char c[4];
	posa.x=datos[a].pos.x; posa.y=datos[a].pos.y;
	posb.x=datos[b].pos.x; posb.y=datos[b].pos.y;
	int i,j;
	for( ; datos[a].pos.y>100; datos[a].pos.y-=30, datos[b].pos.y-=30)
	{	if(SDL_PollEvent(&event))	
			if(event.type==SDL_KEYDOWN  && event.key.keysym.sym)
			{	ventana_entrada();
			}
		SDL_Delay(80);
		SDL_BlitSurface(background,NULL,screen,&pos);
		pintar_burbujas(a,b);
		sprintf(c,"%d",datos[a].n);
                print_on_screen(&c[0],datos[a].pos.x+20,datos[a].pos.y+12,color1,font_num);
                SDL_BlitSurface(burbuja_imagen,NULL,screen,&(datos[a].pos));
		sprintf(c,"%d",datos[b].n);
                print_on_screen(&c[0],datos[b].pos.x+20,datos[b].pos.y+12,color1,font_num);
                SDL_BlitSurface(burbuja_imagen,NULL,screen,&(datos[b].pos));
		SDL_Flip(screen);
	}
}
void movimiento_burbuja_regreso(int a,int b)
{       SDL_Rect posa,posb,pos;pos.x=0;pos.y=0;
        char c[4];
        posa.x=datos[a].pos.x; posa.y=datos[a].pos.y;
        posb.x=datos[b].pos.x; posb.y=datos[b].pos.y;
        int i,j;
	SDL_Event event;
        for( ; datos[a].pos.y<440; datos[a].pos.y+=30, datos[b].pos.y+=30)
        {      
		if(SDL_PollEvent(&event))
                        if(event.type==SDL_KEYDOWN  && event.key.keysym.sym)
                        {       ventana_entrada();
                        }
                SDL_BlitSurface(background,NULL,screen,&pos);
                pintar_burbujas(a,b);
                sprintf(c,"%d",datos[a].n);
                print_on_screen(&c[0],datos[a].pos.x+20,datos[a].pos.y+12,color1,font_num);
                SDL_BlitSurface(burbuja_imagen,NULL,screen,&(datos[a].pos));
                sprintf(c,"%d",datos[b].n);
                print_on_screen(&c[0],datos[b].pos.x+20,datos[b].pos.y+12,color1,font_num);
                SDL_BlitSurface(burbuja_imagen,NULL,screen,&(datos[b].pos));
                SDL_Flip(screen);
		SDL_Delay(80);
        }
	
}

		
void simulacion_burbuja()
{	SDL_Rect pos;pos.x=0; pos.y=0;
	SDL_BlitSurface(background,NULL,screen,&pos);
	SDL_Flip(screen);
	int x,y,i,n=(cantidad+1)*70;n=1000-n; n/=2;
	char c[6];
	SDL_Event event;
	x=n-30; y=440;
	for(i=0; i<cantidad;i++)
	{	x+=70;
		datos[i].pos.x=x; datos[i].pos.y=y;
		sprintf(c,"%d",datos[i].n);
                print_on_screen(&c[0],datos[i].pos.x+20,datos[i].pos.y+12,color1,font_num);
		SDL_BlitSurface(burbuja_imagen,NULL,screen,&(datos[i].pos));
       		SDL_Flip(screen);
		if(SDL_PollEvent(&event))
                        if(event.type==SDL_KEYDOWN  && event.key.keysym.sym)
                        {       ventana_entrada();
                        }
		SDL_Delay(80);
	}
	burbuja(cantidad);
	
	pos.x=0; pos.y=0;
        SDL_BlitSurface(background,NULL,screen,&pos);
	x=n-30; y=440;
	for(i=0; i<cantidad;i++)
        {       x+=70;
                datos[i].pos.x=x; datos[i].pos.y=y;
                sprintf(c,"%d",datos[i].n);
                print_on_screen(&c[0],datos[i].pos.x+20,datos[i].pos.y+12,color1,font_num);
                SDL_BlitSurface(burbuja_imagen,NULL,screen,&(datos[i].pos));
         
        }
	SDL_Flip(screen);	
	SDL_Delay(1500);
	ventana_entrada();
}
void pintar_burbujas(int a,int b)
{	SDL_Rect pos;pos.x=0; pos.y=0;
        int x,y,i,n=(cantidad+1)*70;n=1000-n; n/=2;
        char c[6];
        x=n-30; y=440;
        for(i=0; i<cantidad;i++)
        {       x+=70;
		if(i!=a && i!=b)
		{
                	datos[i].pos.x=x; datos[i].pos.y=y;
    	            	sprintf(c,"%d",datos[i].n);
                	print_on_screen(&c[0],datos[i].pos.x+20,datos[i].pos.y+12,color1,font_num);
                	SDL_BlitSurface(burbuja_imagen,NULL,screen,&(datos[i].pos));
		}
        }
}
void cargando_interface()
{	int i;
	for(i=0,cantidad=10; i<cantidad;i++)
		datos[i].n=i*13%6;
	
	color1.r=0; color1.g=0; color1.b=0;
	font_num=TTF_OpenFont("files/fonts/robot.ttf",30);
	if(font_num==NULL) 	
		printf("No se puede cargar font robot\n");
	font=TTF_OpenFont("files/fonts/robot_2.ttf",20);
	if(font==NULL)
		printf("No se puede cargar font\n");
	fontmax=TTF_OpenFont("files/fonts/robot_2.ttf",60);
	Load_image(&background,"files/imagenes/background.jpg");
	Load_image(&entrada,"files/imagenes/entrada.jpg");
	Load_image(&burbuja_imagen,"files/imagenes/burbuja.png");
	Load_image(&imagen_cuadrito,"files/imagenes/cuadrito.png");
	Load_image(&si,"files/imagenes/si.png");
	Load_image(&insertar_dato,"files/imagenes/insertar.png");
	Load_image(&acerca,"files/imagenes/acercade.png");
	Load_image(&no,"files/imagenes/no.png");
}
void Load_image(SDL_Surface **image,char *ptr)
{       *image=IMG_Load(ptr);
        if(*image==NULL)
               printf("Error no se cargo %s\n ",ptr);
       
}
int posicion_cursor(int xi,int xf,int yi,int yf,int mousex,int mousey)
{       if(mousex>=xi && mousex<=xf && mousey>=yi && mousey<=yf)
                return 1;
        return 0;
}

void print_on_screen(char *c,int x,int y,SDL_Color color,TTF_Font *fonti)
{       SDL_Rect pos;
        pos.x=x; pos.y=y;
        SDL_Surface *letras;
        letras=TTF_RenderText_Solid(fonti,c,color);
        SDL_BlitSurface(letras,NULL,screen,&pos);
}
