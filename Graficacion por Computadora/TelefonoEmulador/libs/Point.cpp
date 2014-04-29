#ifndef _POINT_CPP_
#define _POINT_CPP_

#include "Point.h"

Point::Point( double x, double y ){
	setX( (double)x );
	setY( (double)y );
}

Point::Point( int x , int y ){
	setX( x );
	setY( y );
}

Point::Point( ){
	setX( 0 );
	setY( 0 );
}

int Point::getXd( ){
	return (int)this->x;
}

double Point::getXf( ){
	return this->x;
}

int Point::getYd( ){
	return (int)this->y;
}

double Point::getYf( ){
	return this->y;
}

void Point::setX( int x ){
	this-> x = (double)x;
}

void Point::setX( double x ){
	this-> x = x;
}

void Point::setY( int y ){
	this-> y = (double)y;
}

void Point::setY( double y ){
	this-> y = y;
}

void Point::set( double x, double y ){
	setX( x );
	setY( y );
}

void Point::set( int x, int y ){
	setX( x );
	setY( y );
}

void Point::print( ){
	std::cout<<" ( "<<x<<" , "<<y<<") ";
}

void Point::println( ){
	print( );
	std::cout<<"\n";
}


#endif