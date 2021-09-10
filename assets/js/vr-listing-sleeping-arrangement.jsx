import React from 'react';
import ReactDOM from 'react-dom';
import styled from 'styled-components';
import SleepingArrangement from '@propertybrands/btt-bluetent-components/components/Rooms/SleepingArrangement';

{ /* eslint-disable */ }
{ /* eslint no-lone-blocks: "off" */ }
const element = document.querySelector('.sleeping-arrangements');
if (element) {
  const rooms = JSON.parse(element.dataset.rezfusionRooms.toString());
  const StyledDiv = styled.div`
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    grid-row-gap: 1rem;
    grid-column-gap: 1rem;
    margin: 1rem 0;
  `;
  if (Array.isArray(rooms) && rooms.length) {
    const Rooms = () => (
      <StyledDiv>
        {rooms.map((room) => {
          const bedCounts = {
            bunk_beds: room.bunk_beds,
            child_beds: room.child_beds,
            cribs: room.cribs,
            double_beds: room.double_beds,
            king_beds: room.king_beds,
            murphy_beds: room.murphy_beds,
            other_beds: room.other_beds,
            queen_beds: room.queen_beds,
            single_beds: room.single_beds,
            sofa_beds: room.sofa_beds,
          };
          return (
            <SleepingArrangement {...room} bedCounts={bedCounts} key={room.name}/>
          );
        })}
      </StyledDiv>
    );
    ReactDOM.render(<Rooms />, element);
  }
}
